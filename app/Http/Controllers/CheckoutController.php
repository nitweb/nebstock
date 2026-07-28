<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SiteSettings;
use App\Models\TaxRate;

class CheckoutController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function getTaxRate(string $country): float
    {
        return TaxRate::getRateForCountry($country);
    }

    private function getCartIdentifier(): array
    {
        if (Auth::guard('user')->check()) {
            return ['user_id' => Auth::guard('user')->id()];
        }
        return ['session_id' => session()->getId()];
    }

    private function cartSubtotal($cartItems): float
    {
        return (float) $cartItems->sum(function ($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });
    }

    private function getShippingMethods(string $country): array
    {
        $map = [
            'BD' => [
                ['value' => 'inside_dhaka',  'label' => 'Inside Dhaka',   'cost' => 60,  'po_box_only' => false],
                ['value' => 'outside_dhaka', 'label' => 'Outside Dhaka',  'cost' => 120, 'po_box_only' => false],
            ],
            'US' => [
                ['value' => 'standard', 'label' => 'Standard (7–14 days)', 'cost' => 15, 'po_box_only' => false],
                ['value' => 'express',  'label' => 'Express (3–5 days)',   'cost' => 30, 'po_box_only' => false],
                ['value' => 'economy',  'label' => 'Economy USPS',         'cost' => 8,  'po_box_only' => true],
            ],
            'GB' => [
                ['value' => 'standard', 'label' => 'Standard (7–14 days)', 'cost' => 15, 'po_box_only' => false],
                ['value' => 'express',  'label' => 'Express (3–5 days)',   'cost' => 30, 'po_box_only' => false],
            ],
            'IN' => [
                ['value' => 'standard_in', 'label' => 'Standard Shipping', 'cost' => 10, 'po_box_only' => false],
            ],
        ];

        return $map[$country] ?? [['value' => 'standard', 'label' => 'Standard Shipping (10–21 days)', 'cost' => 20, 'po_box_only' => false]];
    }

    private function getShippingCost(string $country, string $method): float
    {
        foreach ($this->getShippingMethods($country) as $m) {
            if ($m['value'] === $method) {
                return (float) $m['cost'];
            }
        }
        return 0.0;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Guest Account Auto-Create
    // ─────────────────────────────────────────────────────────────────────────

    private function resolveGuestUser(Request $request): ?int
    {
        if (Auth::guard('user')->check()) {
            return Auth::guard('user')->id();
        }

        $email    = trim($request->email);
        $existing = User::where('email', $email)->first();

        if ($existing) {
            return $existing->id;
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $email,
            'password' => Hash::make(Str::random(12)),
            'phone'    => $request->phone,
            'address'  => $request->address,
            'photo'    => 'avatar.png',
            'role'     => 'guest',
            'status'   => '1',
        ]);

        return $user->id;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PayPal Helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function getPayPalAccessToken(): string
    {
        $clientId     = config('paypal.client_id');
        $clientSecret = config('paypal.client_secret');
        $baseUrl      = config('paypal.base_url');

        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post("{$baseUrl}/v1/oauth2/token", ['grant_type' => 'client_credentials']);

        if ($response->failed()) {
            Log::error('PayPal token error', $response->json());
            throw new \Exception('Could not authenticate with PayPal.');
        }

        return $response->json('access_token');
    }

    private function createPayPalOrder(float $amount, string $currency, string $referenceId): string
    {
        $token   = $this->getPayPalAccessToken();
        $baseUrl = config('paypal.base_url');

        $response = Http::withToken($token)->post("{$baseUrl}/v2/checkout/orders", [
            'intent'         => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => $referenceId,
                'amount'       => [
                    'currency_code' => $currency,
                    'value'         => number_format($amount, 2, '.', ''),
                ],
            ]],
        ]);

        if ($response->failed()) {
            Log::error('PayPal create order error', $response->json());
            throw new \Exception('Could not create PayPal order.');
        }

        return $response->json('id');
    }

    private function capturePayPalOrder(string $paypalOrderId): array
    {
        $token   = $this->getPayPalAccessToken();
        $baseUrl = config('paypal.base_url');

        $response = Http::withToken($token)->post("{$baseUrl}/v2/checkout/orders/{$paypalOrderId}/capture");

        if ($response->failed()) {
            Log::error('PayPal capture error', $response->json());
            throw new \Exception('Could not capture PayPal payment.');
        }

        return $response->json();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Stripe Helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function bootStripe(): void
    {
        Stripe::setApiKey(config('stripe.secret_key'));
    }

    private function createStripePaymentIntent(float $amount, string $currency, string $orderNumber): array
    {
        $this->bootStripe();

        $amountInSmallestUnit = (int) round($amount * 100);

        $intent = PaymentIntent::create([
            'amount'                    => $amountInSmallestUnit,
            'currency'                  => strtolower($currency),
            'metadata'                  => ['order_number' => $orderNumber],
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        return [
            'client_secret'     => $intent->client_secret,
            'payment_intent_id' => $intent->id,
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /checkout
    // ─────────────────────────────────────────────────────────────────────────

    public function index()
    {
        $cartItems = Cart::where($this->getCartIdentifier())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });

        $total                = $subtotal;
        $customer             = Auth::guard('user')->user();
        $stripePublishableKey = config('stripe.publishable_key');

        return view('frontend.pages.checkout', compact('cartItems', 'subtotal', 'total', 'customer', 'stripePublishableKey'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /checkout/shipping-methods  (AJAX)
    // ─────────────────────────────────────────────────────────────────────────

    public function shippingMethods(Request $request)
    {
        $request->validate(['country' => 'required|string|max:10']);

        $methods = $this->getShippingMethods(strtoupper($request->country));

        if (empty($methods)) {
            return response()->json(['success' => false, 'message' => 'No shipping methods available for the selected country.']);
        }

        return response()->json(['success' => true, 'methods' => $methods]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /checkout/calculate  (AJAX)
    // ─────────────────────────────────────────────────────────────────────────

    public function calculate(Request $request)
    {
        $request->validate([
            'country'         => 'required|string|max:10',
            'shipping_method' => 'required|string',
        ]);

        $cartItems    = Cart::where($this->getCartIdentifier())->with('product')->get();
        $subtotal     = $this->cartSubtotal($cartItems);
        $shippingCost = $this->getShippingCost(strtoupper($request->country), $request->shipping_method);

        return response()->json([
            'subtotal' => $subtotal,
            'shipping' => $shippingCost,
            'total'    => $subtotal + $shippingCost,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /checkout/tax-rate  (AJAX)
    // ─────────────────────────────────────────────────────────────────────────

    public function getTaxRateAjax(Request $request)
    {
        $request->validate(['country' => 'required|string|max:10']);

        $country = strtoupper($request->country);
        $rate    = $this->getTaxRate($country);

        return response()->json([
            'success' => true,
            'rate'    => (float) $rate,
            'country' => $country,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /checkout/place-order
    // ─────────────────────────────────────────────────────────────────────────

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:200',
            'email'           => 'required|email|max:150',
            'phone'           => 'required|string|max:30',
            'address'         => 'required|string|max:255',
            'city'            => 'required|string|max:100',
            'country'         => 'required|string|max:10',
            'postal_code'     => 'nullable|string|max:20',
            'shipping_method' => 'required|string',
            'payment_method'  => 'required|in:cod,bank_transfer,paypal,stripe',
        ]);

        // ── PO Box check ──────────────────────────────────────────────────────
        if (strtoupper($request->country) === 'US' && $request->shipping_method === 'economy') {
            $isPoBox = (bool) preg_match('/\b(P\.?\s*O\.?\s*Box|Post\s*Office\s*Box)\b/i', $request->address ?? '');
            if (!$isPoBox) {
                return response()->json(['success' => false, 'message' => 'Economy (USPS) is only available for PO Box addresses.'], 422);
            }
        }

        // ── Cart ──────────────────────────────────────────────────────────────
        $cartItems = Cart::where($this->getCartIdentifier())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 422);
        }

        // ── Guest user → auto account create ─────────────────────────────────
        $userId = $this->resolveGuestUser($request);

        // ── Financials ────────────────────────────────────────────────────────
        $subtotal     = $this->cartSubtotal($cartItems);
        $shippingCost = $this->getShippingCost(strtoupper($request->country), $request->shipping_method);
        $discount     = 0;

        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('coupon_code', strtoupper(trim($request->coupon_code)))->first();
            if ($coupon) {
                $discount = $coupon->calculateDiscount($subtotal);
                $coupon->increment('used_count');
            }
        }

        $taxableAmount = max(0, $subtotal - $discount);
        $taxRate       = $this->getTaxRate(strtoupper($request->country));
        $taxAmount     = round($taxableAmount * $taxRate / 100, 2);
        $total         = $taxableAmount + $shippingCost + $taxAmount;
        $hasPreOrder   = $cartItems->contains(fn($item) => $item->product->is_pre_order);

        // ── Create Order ──────────────────────────────────────────────────────
        $order = Order::create([
            'order_number'    => 'ORD-' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
            'user_id'         => $userId,
            'name'            => $request->name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'company'         => $request->company,
            'address'         => $request->address,
            'city'            => $request->city,
            'country'         => $request->country,
            'postal_code'     => $request->postal_code,
            'order_notes'     => $request->order_notes,
            'payment_method'  => $request->payment_method,
            'billing_type'    => $request->billing_type ?? 'same',
            'ship_first_name' => $request->ship_first_name,
            'ship_last_name'  => $request->ship_last_name,
            'ship_address'    => $request->ship_address,
            'ship_city'       => $request->ship_city,
            'ship_postal'     => $request->ship_postal,
            'ship_country'    => $request->ship_country,
            'subtotal'        => $subtotal,
            'discount'        => $discount,
            'tax'             => $taxAmount,
            'tax_rate'        => $taxRate,
            'shipping_cost'   => $shippingCost,
            'total'           => $total,
            'order_type'      => $hasPreOrder ? 'pre_order' : 'normal',
            'status'          => 'pending',
            'payment_status'  => 'pending',
            'shipping_method' => $request->shipping_method,
        ]);

        // ── Order Items ───────────────────────────────────────────────────────
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->discount_price ?? $item->product->price,
            ]);
        }

        // ── COD / Bank Transfer ───────────────────────────────────────────────
        if (in_array($request->payment_method, ['cod', 'bank_transfer'])) {
            if (!$hasPreOrder) {
                $order->update(['status' => 'processing']);
            }

            Cart::where($this->getCartIdentifier())->delete();

            return response()->json([
                'success'  => true,
                'message'  => 'Order placed successfully!',
                'redirect' => route('order.success', $order->order_number),
            ]);
        }

        // ── PayPal ────────────────────────────────────────────────────────────
        if ($request->payment_method === 'paypal') {
            try {
                $currency      = config('paypal.currency', 'GBP');
                $paypalOrderId = $this->createPayPalOrder($total, $currency, $order->order_number);

                $order->update(['paypal_order_id' => $paypalOrderId]);

                return response()->json([
                    'success'         => true,
                    'paypal'          => true,
                    'paypal_order_id' => $paypalOrderId,
                    'order_number'    => $order->order_number,
                ]);
            } catch (\Exception $e) {
                $order->items()->delete();
                $order->delete();
                return response()->json(['success' => false, 'message' => 'PayPal error: ' . $e->getMessage()], 500);
            }
        }

        // ── Stripe ────────────────────────────────────────────────────────────
        if ($request->payment_method === 'stripe') {
            try {
                $currency = config('stripe.currency', 'gbp');
                $stripe   = $this->createStripePaymentIntent($total, $currency, $order->order_number);

                $order->update(['transaction_id' => $stripe['payment_intent_id']]);

                return response()->json([
                    'success'       => true,
                    'stripe'        => true,
                    'client_secret' => $stripe['client_secret'],
                    'order_number'  => $order->order_number,
                ]);
            } catch (\Exception $e) {
                $order->items()->delete();
                $order->delete();
                Log::error('Stripe PaymentIntent error', ['error' => $e->getMessage()]);
                return response()->json(['success' => false, 'message' => 'Stripe error: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Unknown payment method.'], 422);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /checkout/paypal/capture
    // ─────────────────────────────────────────────────────────────────────────

    public function paypalCapture(Request $request)
    {
        $request->validate([
            'paypal_order_id' => 'required|string',
            'order_number'    => 'required|string',
        ]);

        $order = Order::where('order_number', $request->order_number)->firstOrFail();

        if ($order->payment_status === 'paid') {
            return response()->json([
                'success'  => true,
                'redirect' => route('order.success', $order->order_number),
            ]);
        }

        try {
            $capture   = $this->capturePayPalOrder($request->paypal_order_id);
            $captureId = data_get($capture, 'purchase_units.0.payments.captures.0.id');
            $status    = data_get($capture, 'status');

            if ($status === 'COMPLETED' && $captureId) {
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $captureId,
                    'status'         => $order->order_type === 'pre_order' ? 'pending' : 'processing',
                ]);

                Cart::where($this->getCartIdentifier())->delete();

                return response()->json([
                    'success'  => true,
                    'redirect' => route('order.success', $order->order_number),
                ]);
            }

            return response()->json(['success' => false, 'message' => 'PayPal payment not completed.'], 422);
        } catch (\Exception $e) {
            Log::error('PayPal capture failed', ['error' => $e->getMessage(), 'order' => $order->order_number]);
            $order->update(['payment_status' => 'failed']);
            return response()->json(['success' => false, 'message' => 'Payment capture failed. Please contact support.'], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /checkout/stripe/capture
    // ─────────────────────────────────────────────────────────────────────────

    public function stripeCapture(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'order_number'      => 'required|string',
        ]);

        $order = Order::where('order_number', $request->order_number)->firstOrFail();

        if ($order->payment_status === 'paid') {
            return response()->json([
                'success'  => true,
                'redirect' => route('order.success', $order->order_number),
            ]);
        }

        try {
            $this->bootStripe();
            $intent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($intent->status === 'succeeded') {
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $intent->id,
                    'status'         => $order->order_type === 'pre_order' ? 'pending' : 'processing',
                ]);

                Cart::where($this->getCartIdentifier())->delete();

                return response()->json([
                    'success'  => true,
                    'redirect' => route('order.success', $order->order_number),
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Stripe payment not completed. Status: ' . $intent->status], 422);
        } catch (\Exception $e) {
            Log::error('Stripe capture failed', ['error' => $e->getMessage(), 'order' => $order->order_number]);
            $order->update(['payment_status' => 'failed']);
            return response()->json(['success' => false, 'message' => 'Payment verification failed. Please contact support.'], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /checkout/stripe/webhook
    // ─────────────────────────────────────────────────────────────────────────

    public function stripeWebhook(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature.'], 400);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload.'], 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;
            $order  = Order::where('transaction_id', $intent->id)->first();

            if ($order && $order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'status'         => $order->order_type === 'pre_order' ? 'pending' : 'processing',
                ]);
            }
        }

        if ($event->type === 'payment_intent.payment_failed') {
            $intent = $event->data->object;
            $order  = Order::where('transaction_id', $intent->id)->first();

            if ($order && $order->payment_status === 'pending') {
                $order->update(['payment_status' => 'failed']);
            }
        }

        return response()->json(['received' => true]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /order/success/{orderNumber}
    // ─────────────────────────────────────────────────────────────────────────

    public function orderSuccess(string $orderNumber)
    {
        $query = Order::where('order_number', $orderNumber)->with('items.product');

        if (Auth::guard('user')->check()) {
            $query->where('user_id', Auth::guard('user')->id());
        }

        $order = $query->firstOrFail();

        return view('frontend.pages.order-success', compact('order'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /coupon/apply
    // ─────────────────────────────────────────────────────────────────────────

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('coupon_code', strtoupper(trim($request->code)))->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
        }

        $cartItems = Cart::where($this->getCartIdentifier())->with('product')->get();
        $cartTotal = $this->cartSubtotal($cartItems);
        $check     = $coupon->isValid($cartTotal);

        if (!$check['valid']) {
            return response()->json(['success' => false, 'message' => $check['message']]);
        }

        return response()->json([
            'success'         => true,
            'message'         => 'Coupon applied!',
            'discount_amount' => $coupon->calculateDiscount($cartTotal),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /my-orders  (login required)
    // ─────────────────────────────────────────────────────────────────────────

    public function myOrders(Request $request)
    {
        $customer = Auth::guard('user')->user();

        $orders = Order::with(['items.product'])
            ->where('user_id', $customer->id)
            ->latest()
            ->get()
            ->map(function ($order) {
                return [
                    'id'              => $order->id,
                    'order_number'    => $order->order_number,
                    'date'            => $order->created_at->format('d M Y'),
                    'status'          => $order->status,
                    'status_label'    => $order->status_label,
                    'status_color'    => $order->status_color,
                    'payment_status'  => $order->payment_status ?? 'pending',
                    'payment_method'  => $order->payment_method,
                    'subtotal'        => number_format($order->subtotal, 2),
                    'discount'        => number_format($order->discount, 2),
                    'tax'             => number_format($order->tax ?? 0, 2),
                    'tax_rate'        => number_format($order->tax_rate ?? 0, 2),
                    'shipping_cost'   => number_format($order->shipping_cost, 2),
                    'shipping_method' => $order->shipping_method ?? 'Standard',
                    'total'           => number_format($order->total, 2),
                    'address' => implode(', ', array_filter([$order->address, $order->city, $order->country_name])),
                    'phone'           => $order->phone,
                    'invoice_url'     => route('customer.order.invoice', $order->id),
                    'items'           => $order->items->map(function ($item) {
                        $img = $item->product?->cover_image
                            ? asset('upload/product_covers/' . $item->product->cover_image)
                            : asset('upload/no_image.jpg');
                        return [
                            'name'     => $item->product_name,
                            'quantity' => $item->quantity,
                            'price'    => number_format($item->unit_price, 2),
                            'subtotal' => number_format($item->subtotal, 2),
                            'image'    => $img,
                        ];
                    }),
                ];
            });

        return response()->json(['success' => true, 'orders' => $orders]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /order/{id}/invoice  (login required)
    // ─────────────────────────────────────────────────────────────────────────

    public function downloadInvoice(int $id)
    {
        $customer = Auth::guard('user')->user();

        $order = Order::with(['user', 'items.product'])
            ->where('id', $id)
            ->where('user_id', $customer->id)
            ->firstOrFail();

        $settings = SiteSettings::first();

        $pdf = Pdf::loadView('backend.orders.invoice', compact('order', 'settings'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'isLocalLinksEnabled'  => true,
                'defaultFont'          => 'DejaVu Sans',
                'dpi'                  => 150,
                'chroot'               => public_path(),
            ]);

        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }
}
