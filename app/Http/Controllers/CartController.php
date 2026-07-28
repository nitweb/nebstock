<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ✅ Helper: Current user বা session এর identifier return করে
    private function getCartIdentifier()
    {
        if (Auth::guard('user')->check()) {
            return ['user_id' => Auth::guard('user')->id()];
        }
        return ['session_id' => session()->getId()];
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // ✅ শুধু তখনই block করো যখন:
        // out_of_stock AND is_pre_order false AND request এ pre_order flag নেই
        $isPreOrderRequest = $request->boolean('is_pre_order');

        if ($product->stock_status === 'out_of_stock' && !$product->is_pre_order && !$isPreOrderRequest) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'This product is out of stock.',
                ],
                422,
            );
        }

        $identifier = $this->getCartIdentifier();

        $cartItem = Cart::where($identifier)->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity ?? 1);
        } else {
            Cart::create(
                array_merge($identifier, [
                    'product_id' => $product->id,
                    'quantity' => $request->quantity ?? 1,
                    'session_id' => session()->getId(),
                ]),
            );
        }

        $cartCount = Cart::where($identifier)->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => $product->is_pre_order || $isPreOrderRequest ? 'Pre-order added to cart!' : 'Product added to cart',
            'cart_count' => $cartCount,
        ]);
    }

    public function cartCount()
    {
        $count = Cart::where($this->getCartIdentifier())->sum('quantity');
        return response()->json(['count' => $count]);
    }

    public function cartItems()
    {
        $items = Cart::where($this->getCartIdentifier())->with('product')->get();

        $total = $items->sum(fn($i) => ($i->product->discount_price ?? $i->product->price) * $i->quantity);

        return response()->json([
            'items' => $items,
            'total' => number_format($total, 2),
        ]);
    }

    public function removeItem($id)
    {
        Cart::where($this->getCartIdentifier())->where('id', $id)->delete();

        return response()->json(['success' => true]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'change' => 'required|integer',
        ]);

        $cartItem = Cart::where($this->getCartIdentifier())->where('id', $request->cart_id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->change;

            if ($newQuantity > 0) {
                $cartItem->update(['quantity' => $newQuantity]);
                return response()->json(['success' => true, 'quantity' => $newQuantity]);
            } elseif ($newQuantity <= 0) {
                $cartItem->delete();
                return response()->json(['success' => true, 'deleted' => true]);
            }
        }

        return response()->json(['success' => false], 404);
    }

    public function viewCart()
    {
        $cartItems = Cart::where($this->getCartIdentifier())->with('product')->get();

        $subtotal = $cartItems->sum(function ($item) {
            // discount_price আছে তাহলে সেটাই final price, না হলে price
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });

        return view('frontend.pages.cart', compact('cartItems', 'subtotal'));
    }

    public function clearCart()
    {
        Cart::where($this->getCartIdentifier())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
        ]);
    }
}
