@extends('frontend.dashboard')
@section('frontend_title', 'Checkout')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Checkout</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ route('cart.view') }}">Cart</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Checkout</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div class="co-toast-wrap" id="co-toast-wrap"></div>

    <div class="co-shell">
        <!-- LEFT -->
        <div class="co-left">

            <form id="checkout-form" action="{{ route('checkout.place.order') }}" method="POST">

                @csrf
                <input type="hidden" name="coupon_code" id="hidden_coupon_code" value="{{ old('coupon_code', '') }}">

                {{-- Contact --}}
                <div class="co-section">
                    <div class="co-section-title">Contact</div>

                    @guest('user')
                        <div style="background:#f0f7ff;border:1.5px solid #bfdbfe;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#1e40af;display:flex;gap:10px;align-items:center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="flex-shrink:0">
                                <circle cx="12" cy="12" r="10" stroke="#3b82f6" stroke-width="1.8" />
                                <path d="M12 8v4M12 16h.01" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span>
                                Already have an account?
                                <a href="{{ route('customer.login') }}?redirect={{ urlencode(route('checkout')) }}" style="color:#2563eb;font-weight:600;text-decoration:underline;">Log in</a>
                                for faster checkout. Or continue as guest below.
                            </span>
                        </div>
                    @endguest

                    <div class="form-group">
                        <label>Email <span class="req">*</span></label>
                        <input class="co-input" type="email" name="email" value="{{ old('email', $customer->email ?? '') }}" required>
                    </div>
                    <label class="co-check">
                        <input type="checkbox" name="email_offers" {{ old('email_offers') ? 'checked' : '' }}>
                        <span class="co-check-box"></span>
                        Email me with news and offers
                    </label>
                </div>

                {{-- Delivery --}}
                <div class="co-section">
                    <div class="co-section-title">Delivery</div>

                    <div class="form-group">
                        <label>Country / Region <span class="req">*</span></label>
                        <div class="co-select-wrap">
                            <select class="co-select co-country-select" name="country" id="country" required>
                                <option value="">Select Country</option>
                                @foreach ([
            'AT' => 'Austria',
            'BE' => 'Belgium',
            'BG' => 'Bulgaria',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DE' => 'Germany',
            'DK' => 'Denmark',
            'EE' => 'Estonia',
            'EL' => 'Greece',
            'ES' => 'Spain',
            'FI' => 'Finland',
            'FR' => 'France',
            'HR' => 'Croatia',
            'HU' => 'Hungary',
            'IE' => 'Ireland',
            'IT' => 'Italy',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'LV' => 'Latvia',
            'MT' => 'Malta',
            'NL' => 'Netherlands',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'RO' => 'Romania',
            'SE' => 'Sweden',
            'SI' => 'Slovenia',
            'SK' => 'Slovakia',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'BD' => 'Bangladesh',
            'IN' => 'India',
            'CA' => 'Canada',
            'AU' => 'Australia',
            'SG' => 'Singapore',
            'AE' => 'United Arab Emirates',
            'SA' => 'Saudi Arabia',
            'PK' => 'Pakistan',
            'NG' => 'Nigeria',
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            'AG' => 'Antigua and Barbuda',
        ] as $code => $name)
                                    <option value="{{ $code }}" {{ old('country', $customer->country ?? '') == $code ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="co-select-arrow">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M6 9l6 6 6-6" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name <span class="req">*</span></label>
                            <input class="co-input" type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Company (optional)</label>
                        <input class="co-input" type="text" name="company" value="{{ old('company', $customer->company ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label>Street Address <span class="req">*</span></label>
                        <input class="co-input" type="text" name="address" value="{{ old('address', $customer->address ?? '') }}" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>City <span class="req">*</span></label>
                            <input class="co-input" type="text" name="city" value="{{ old('city', $customer->city ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Postal Code <span class="req">*</span></label>
                            <input class="co-input" type="text" name="postal_code" value="{{ old('postal_code', $customer->postal_code ?? '') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Phone <span class="req">*</span></label>
                        <input class="co-input" type="text" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" required>
                    </div>

                    <label class="co-check">
                        <input type="checkbox" name="save_info" id="save_info" {{ old('save_info', $customer ? '1' : '') ? 'checked' : '' }}>
                        <span class="co-check-box"></span>
                        Save this information for next time
                    </label>
                </div>

                {{-- Ship to different address --}}
                <div class="co-section">
                    <div class="ship-toggle" id="ship-toggle">
                        <label class="co-check" style="margin:0;">
                            <input type="checkbox" id="ship_different" {{ old('ship_first_name') || old('ship_last_name') || old('ship_address') ? 'checked' : '' }}>
                            <span class="co-check-box"></span>
                        </label>
                        Ship to a different address?
                    </div>

                    <div class="ship-body {{ old('ship_first_name') || old('ship_last_name') || old('ship_address') ? 'open' : '' }}" id="ship-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="co-input" type="text" name="ship_first_name" placeholder="First name" value="{{ old('ship_first_name', '') }}">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="co-input" type="text" name="ship_last_name" placeholder="Last name" value="{{ old('ship_last_name', '') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Street Address</label>
                            <input class="co-input" type="text" name="ship_address" placeholder="Street address" value="{{ old('ship_address', '') }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>City</label>
                                <input class="co-input" type="text" name="ship_city" placeholder="City" value="{{ old('ship_city', '') }}">
                            </div>
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input class="co-input" type="text" name="ship_postal" placeholder="Postal code" value="{{ old('ship_postal', '') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Country / Region</label>
                            <div class="co-select-wrap">
                                <select class="co-select co-country-select" name="ship_country">
                                    <option value="">Select Country</option>
                                    @foreach (['BD' => 'Bangladesh', 'IN' => 'India', 'US' => 'United States', 'GB' => 'United Kingdom', 'NL' => 'Netherlands'] as $c => $cn)
                                        <option value="{{ $c }}" {{ old('ship_country') == $c ? 'selected' : '' }}>{{ $cn }}</option>
                                    @endforeach
                                </select>
                                <span class="co-select-arrow">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 9l6 6 6-6" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Shipping Method --}}
                <div class="co-section" id="shipping-section">
                    <div class="co-section-title">Shipping Method</div>

                    <div id="shipping-loading" style="display:none;">
                        <div class="shipping-skeleton"></div>
                        <div class="shipping-skeleton" style="width:70%"></div>
                    </div>

                    <div id="shipping-placeholder" class="shipping-placeholder">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Select a country above to see available shipping methods.
                    </div>

                    <div id="shipping-methods-wrap" style="display:none;"></div>
                    <input type="hidden" name="shipping_method" id="shipping_method_input" value="{{ old('shipping_method', '') }}">

                    <div id="pobox-warning" class="pobox-warning" style="display:none;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="#c0392b" stroke-width="2" />
                            <path d="M12 8v4M12 16h.01" stroke="#c0392b" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <span>Economy (USPS) is only available for <strong>PO Box</strong> addresses (US only).</span>
                    </div>

                    <div id="shipping-cost-row" class="shipping-cost-row" style="display:none;">
                        <span class="sc-label">Shipping cost</span>
                        <span class="sc-value" id="shipping-cost-value">$0.00</span>
                    </div>
                </div>

                {{-- Order Notes --}}
                <div class="co-section">
                    <div class="co-section-title">Order Notes</div>
                    <textarea class="co-textarea" name="order_notes" placeholder="Special notes for delivery, gift messages, etc.">{{ old('order_notes', '') }}</textarea>
                </div>

                {{-- Payment Method --}}
                <div class="co-section">
                    <div class="co-section-title">Payment</div>
                    <p style="font-size:12.5px;color:var(--clr-muted);margin-bottom:16px;display:flex;gap:6px;align-items:center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        All transactions are secure and encrypted.
                    </p>

                    <div class="payment-options" id="payment-options">

                        {{-- PayPal --}}
                        <div class="payment-opt {{ old('payment_method', 'paypal') === 'paypal' ? 'active' : '' }}" data-value="paypal">
                            <input type="radio" name="payment_method" value="paypal" {{ old('payment_method', 'paypal') === 'paypal' ? 'checked' : '' }}>
                            <div class="radio-dot"></div>
                            <span class="payment-label">PayPal</span>
                            <div class="payment-icons">
                                <svg height="20" viewBox="0 0 80 22" fill="none">
                                    <text x="0" y="17" font-family="sans-serif" font-weight="900" font-size="16" fill="#003087">Pay</text>
                                    <text x="30" y="17" font-family="sans-serif" font-weight="900" font-size="16" fill="#009CDE">Pal</text>
                                </svg>
                            </div>
                        </div>
                        <div class="payment-note" id="paypal-note" {{ old('payment_method', 'paypal') !== 'paypal' ? 'style=display:none;' : '' }}>
                            You will be redirected to PayPal to complete your purchase securely.
                        </div>

                        {{-- Stripe --}}
                        <div class="payment-opt {{ old('payment_method') === 'stripe' ? 'active' : '' }}" data-value="stripe">
                            <input type="radio" name="payment_method" value="stripe" {{ old('payment_method') === 'stripe' ? 'checked' : '' }}>
                            <div class="radio-dot"></div>
                            <span class="payment-label">Credit / Debit Card</span>
                            <div class="payment-icons" style="display:flex;gap:5px;align-items:center;">
                                <svg width="36" height="24" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="36" height="24" rx="4" fill="#1A1F71" />
                                    <path d="M15.245 16.5H13.09l1.345-8.5h2.155L15.245 16.5zM11.09 8l-2.055 5.83-.243-1.23L8 8.82A.93.93 0 007.1 8H3.52l-.02.13c.85.22 1.6.55 2.24.97l1.9 7.4H9.8L13.2 8h-2.11zM24.97 16.5h1.93L25.27 8h-1.69c-.44 0-.81.26-.97.65l-3.08 7.85h2.16l.43-1.18h2.63l.22 1.18zm-2.27-2.8l1.09-2.98.61 2.98h-1.7zM30.55 10.1c0-.3.28-.62 1.05-.7a4.75 4.75 0 012.44.43l.35-1.62s-.77-.29-1.98-.29c-2.09 0-3.56 1.11-3.57 2.7-.01 1.17 1.05 1.83 1.85 2.22.82.4 1.1.66 1.09 1.02-.01.55-.65.8-1.25.81a4.4 4.4 0 01-2.16-.51l-.38 1.73s.97.45 2.27.45c2.21.01 3.66-1.09 3.67-2.78.01-2.14-2.98-2.26-2.98-2.56z" fill="white" />
                                </svg>
                                <svg width="36" height="24" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="36" height="24" rx="4" fill="#252525" />
                                    <circle cx="14" cy="12" r="6" fill="#EB001B" />
                                    <circle cx="22" cy="12" r="6" fill="#F79E1B" />
                                    <path d="M18 7.6a6 6 0 010 8.8A6 6 0 0118 7.6z" fill="#FF5F00" />
                                </svg>
                            </div>
                        </div>

                        <div id="stripe-card-panel" style="{{ old('payment_method') === 'stripe' ? '' : 'display:none;' }}padding:16px;background:var(--clr-surface,#fff);border:1.5px solid var(--clr-border,#e2e8f0);border-top:none;border-radius:0 0 10px 10px;margin-bottom:4px;">
                            <div id="stripe-card-element" style="padding:12px 14px;border:1.5px solid var(--clr-border,#e2e8f0);border-radius:8px;background:#fafafa;min-height:44px;"></div>
                            <div id="stripe-card-errors" style="color:#e53e3e;font-size:12.5px;margin-top:8px;display:none;"></div>
                        </div>

                        {{-- COD --}}
                        <div class="payment-opt {{ old('payment_method') === 'cod' ? 'active' : '' }}" data-value="cod" style="display:none;">
                            <input type="radio" name="payment_method" value="cod" {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                            <div class="radio-dot"></div>
                            <span class="payment-label">Cash on Delivery</span>
                            <div class="payment-icons">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="6" width="20" height="14" rx="2" stroke="#888" stroke-width="1.5" />
                                    <path d="M2 10h20" stroke="#888" stroke-width="1.5" />
                                    <circle cx="6" cy="16" r="1" fill="#888" />
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Billing Address --}}
                <div class="co-section">
                    <div class="co-section-title">Billing Address</div>
                    <div class="billing-opts">
                        <label class="billing-opt {{ old('billing_type', 'same') === 'same' ? 'active' : '' }}" id="bill-same-lbl">
                            <input type="radio" name="billing_type" value="same" {{ old('billing_type', 'same') === 'same' ? 'checked' : '' }}>
                            <div class="radio-dot"></div>
                            Same as shipping address
                        </label>
                        <label class="billing-opt {{ old('billing_type') === 'different' ? 'active' : '' }}" id="bill-diff-lbl">
                            <input type="radio" name="billing_type" value="different" {{ old('billing_type') === 'different' ? 'checked' : '' }}>
                            <div class="radio-dot"></div>
                            Use a different billing address
                        </label>
                    </div>
                </div>

                {{-- Submit Area --}}
                <div id="submit-area">

                    <button type="submit" class="co-btn-primary" id="place-order-btn" style="display:none;">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Place Order
                    </button>

                    <button type="button" class="co-btn-primary" id="stripe-pay-btn" style="display:none;background:var(--clr-primary,#2563eb);padding: 10px 0 0;">
                        <svg viewBox="0 0 24 24" fill="none" width="18" height="18" style="margin-top: -5px;">
                            <rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2" />
                            <path d="M2 10h20" stroke="currentColor" stroke-width="2" />
                        </svg>
                        Pay with Card
                    </button>

                    <div id="stripe-processing" style="display:none;text-align:center;padding:16px 0;font-size:14px;color:var(--clr-muted);">
                        <svg viewBox="0 0 24 24" fill="none" width="22" height="22" style="animation:spin 1s linear infinite;vertical-align:middle;margin-right:6px;">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        Processing payment, please wait…
                    </div>

                    <div id="paypal-button-container"></div>

                    <div id="paypal-processing" style="display:none;text-align:center;padding:16px 0;font-size:14px;color:var(--clr-muted);">
                        <svg viewBox="0 0 24 24" fill="none" width="22" height="22" style="animation:spin 1s linear infinite;vertical-align:middle;margin-right:6px;">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        Processing payment, please wait…
                    </div>

                </div>

                <p class="policy-links" style="margin-top:14px;">
                    By placing your order, you agree to our
                    <a href="#">Privacy Policy</a> and <a href="#">Terms & Conditions</a>.
                </p>

                <a class="return-link" href="{{ route('cart.view') }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                        <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Return to cart
                </a>
            </form>
        </div>

        <!-- RIGHT -->
        <aside class="co-right">
            <div class="os-title">Your Order</div>

            @if ($cartItems->contains(fn($item) => $item->product->is_pre_order))
                <div style="background:#fff8f0;border:1.5px solid #f0a060;border-radius:10px;padding:14px 18px;margin-bottom:20px;font-size:13px;color:#c0621a;display:flex;gap:10px;align-items:center;">
                    🕐
                    <div>
                        <strong>Your order contains Pre-Order item(s).</strong><br>
                        These items will be shipped on their scheduled date.
                    </div>
                </div>
            @endif

            <div class="os-items">
                @foreach ($cartItems as $item)
                    @php
                        $price = $item->product->discount_price ?? $item->product->price;
                        $itemTotal = $price * $item->quantity;
                    @endphp
                    <div class="os-item">
                        <div class="os-thumb-wrap">
                            <img class="os-thumb" src="{{ asset('upload/product_covers/' . $item->product->cover_image) }}" alt="{{ $item->product->name }}">
                            <span class="os-qty-badge">{{ $item->quantity }}</span>
                        </div>
                        <div class="os-info">
                            <div class="os-name">{{ Str::limit($item->product->name, 28) }}</div>
                            <div class="os-unit">Unit: ${{ number_format($price, 2) }}</div>
                            @if ($item->product->is_pre_order)
                                <div style="font-size:11px;color:#e67e22;font-weight:600;margin-top:2px;">
                                    🕐 {{ $item->product->pre_order_date ? 'Ships ' . $item->product->pre_order_date->format('d M Y') : 'Coming Soon' }}
                                </div>
                            @elseif ($item->product->stock_status === 'out_of_stock')
                                <div style="font-size:11px;color:#e67e22;font-weight:600;margin-top:2px;">
                                    🕐 Pre-Order Item
                                </div>
                            @endif
                        </div>
                        <div class="os-price">${{ number_format($itemTotal, 2) }}</div>
                    </div>
                @endforeach
            </div>

            <div class="os-coupon">
                <input type="text" id="coupon-input" placeholder="Discount code or gift card" value="{{ old('coupon_code', '') }}">
                <button class="os-coupon-btn" type="button" id="apply-coupon-btn">Apply</button>
            </div>
            <div id="coupon-message"></div>

            <div class="os-totals">
                <div class="os-total-row">
                    <span>Subtotal</span>
                    <span id="checkout-subtotal">${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="os-total-row discount" id="discount-row" style="display:none;">
                    <span>Discount</span>
                    <span id="discount-amount">-$0.00</span>
                </div>
                <div class="os-total-row">
                    <span>Shipping</span>
                    <span id="checkout-shipping-cost" style="font-style:italic;font-size:12px;">Select method</span>
                </div>
                {{-- ── TAX ROW ── --}}
                <div class="os-total-row" id="tax-row" style="display:none;">
                    <span>Tax (<span id="tax-rate-label">0</span>%)</span>
                    <span id="tax-amount-display">$0.00</span>
                </div>
                <div class="os-total-row grand">
                    <span>Total</span>
                    <span id="checkout-total">${{ number_format($subtotal, 2) }}</span>
                </div>
            </div>

            <div class="os-notice">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" stroke="#D4880A" stroke-width="2" />
                    <path d="M12 8v4M12 16h.01" stroke="#D4880A" stroke-width="2" stroke-linecap="round" />
                </svg>
                <span>All sales are final. Please review your order before placing.</span>
            </div>

            <div class="secure-tag">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6l-8-4z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                </svg>
                Secure & encrypted checkout
            </div>
        </aside>

    </div>

    {{-- STYLES --}}
    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* ── Native Country Select ── */
        .co-select-wrap {
            position: relative;
            display: block;
        }

        .co-select-wrap .co-country-select {
            width: 100%;
            height: auto;
            border: 1.5px solid var(--clr-border, #e2e8f0);
            border-radius: 8px;
            padding: 11px 40px 11px 14px;
            font-size: 14px;
            color: var(--clr-text, #1e293b);
            background: var(--clr-surface, #fff);
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            line-height: 1.5;
        }

        .co-select-wrap .co-country-select:focus {
            border-color: var(--clr-primary, #2563eb);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
        }

        .co-select-wrap .co-country-select:hover {
            border-color: #94a3b8;
        }

        /* Hide old select-wrap arrow if any */
        .select-wrap::after {
            display: none !important;
        }

        /* ── Shipping ── */
        .ship-method-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ship-method-opt {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border: 1.5px solid var(--clr-border, #e2e8f0);
            border-radius: 10px;
            cursor: pointer;
            transition: border-color .18s, background .18s;
            background: var(--clr-surface, #fff);
            position: relative;
        }

        .ship-method-opt:hover,
        .ship-method-opt.active {
            border-color: var(--clr-primary, #2563eb);
            background: var(--clr-primary-soft, #eff6ff);
        }

        .ship-method-opt input[type=radio] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .ship-radio-dot {
            width: 17px;
            height: 17px;
            border: 2px solid var(--clr-border, #cbd5e1);
            border-radius: 50%;
            flex-shrink: 0;
            transition: border-color .18s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ship-method-opt.active .ship-radio-dot {
            border-color: var(--clr-primary, #2563eb);
        }

        .ship-method-opt.active .ship-radio-dot::after {
            content: '';
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--clr-primary, #2563eb);
            display: block;
        }

        .ship-method-info {
            flex: 1;
        }

        .ship-method-label {
            font-weight: 600;
            font-size: 14px;
            color: var(--clr-text, #1e293b);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ship-po-badge {
            font-size: 10px;
            font-weight: 700;
            background: #fef3c7;
            color: #92400e;
            padding: 2px 7px;
            border-radius: 20px;
            letter-spacing: .3px;
            text-transform: uppercase;
        }

        .ship-method-cost {
            font-size: 14px;
            font-weight: 700;
            color: var(--clr-primary, #2563eb);
            white-space: nowrap;
        }

        .shipping-placeholder {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--clr-muted, #94a3b8);
            font-size: 13px;
            padding: 14px 0 4px;
        }

        .shipping-skeleton {
            height: 52px;
            width: 100%;
            border-radius: 10px;
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
            margin-bottom: 10px;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0
            }

            100% {
                background-position: -200% 0
            }
        }

        .pobox-warning {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 8px;
            padding: 10px 14px;
            margin-top: 10px;
            font-size: 13px;
            color: #c0392b;
            line-height: 1.5;
        }

        .shipping-cost-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed var(--clr-border, #e2e8f0);
            font-size: 13.5px;
        }

        .sc-label {
            color: var(--clr-muted, #64748b);
        }

        .sc-value {
            font-weight: 700;
            color: var(--clr-text, #1e293b);
        }

        #paypal-button-container {
            min-height: 50px;
        }

        #paypal-button-container.pp-hidden {
            display: none !important;
        }

        #stripe-card-element {
            transition: border-color .2s;
        }

        #stripe-card-element.StripeElement--focus {
            border-color: var(--clr-primary, #2563eb) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        #stripe-card-element.StripeElement--invalid {
            border-color: #e53e3e !important;
        }

        /* Select2 styling */
        .select2-container--default .select2-selection--single {
            height: auto;
            border: 1.5px solid var(--clr-border, #e2e8f0);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            color: var(--clr-text, #1e293b);
            background: var(--clr-surface, #fff);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 0;
            line-height: 1.5;
            color: inherit;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50%;
            transform: translateY(-50%);
            right: 10px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--clr-primary, #2563eb);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
            outline: none;
        }

        .select2-dropdown {
            border: 1.5px solid var(--clr-border, #e2e8f0);
            border-radius: 8px;
            font-size: 14px;
            z-index: 99999 !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--clr-primary, #2563eb);
        }

        .select2 span.selection {
            width: 100%;
        }

        .co-select-wrap::after {
            display: none;
        }

        span.co-select-arrow {
            display: none;
        }
    </style>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}&currency={{ config('paypal.currency', 'GBP') }}"></script>

    <script>
        $(document).ready(function() {

            /* ═══════════════ STATE ═══════════════ */
            let selectedShippingMethod = null;
            let currentCountry = null;
            let subtotal = parseFloat('{{ $subtotal }}');
            let appliedDiscount = 0;
            let currentShippingCost = 0;
            let currentTaxRate = 0;
            let currentTaxAmount = 0;

            // Stripe
            let stripeInstance = null;
            let stripeElements = null;
            let stripeCardEl = null;
            let stripeReady = false;

            /* ═══════════════ STRIPE INIT ═══════════════ */
            function initStripe() {
                if (typeof Stripe === 'undefined') return;
                stripeInstance = Stripe('{{ env('STRIPE_TEST_PUBLISHABLE_KEY') }}');
                // stripeInstance = Stripe('{{ config('stripe.publishable_key') }}');
                @if (old('payment_method') === 'stripe')
                    mountStripeCard();
                @endif
            }

            if (typeof Stripe !== 'undefined') {
                initStripe();
            } else {
                document.querySelector('script[src*="stripe"]').addEventListener('load', initStripe);
            }

            function mountStripeCard() {
                if (stripeReady || !stripeInstance) return;
                stripeReady = true;
                stripeElements = stripeInstance.elements();
                stripeCardEl = stripeElements.create('card', {
                    style: {
                        base: {
                            fontSize: '15px',
                            color: '#1e293b',
                            fontFamily: 'inherit',
                            '::placeholder': {
                                color: '#94a3b8'
                            }
                        },
                        invalid: {
                            color: '#e53e3e'
                        },
                    },
                });
                stripeCardEl.mount('#stripe-card-element');
                stripeCardEl.on('change', function(e) {
                    let $err = $('#stripe-card-errors');
                    e.error ? $err.text(e.error.message).show() : $err.hide();
                });
            }

            /* ═══════════════ SHIP TO DIFFERENT ADDRESS ═══════════════ */
            $('#ship_different').on('change', function() {
                $('#ship-body').toggleClass('open', this.checked);
            });

            /* ═══════════════ PAYMENT TOGGLE ═══════════════ */
            $('#payment-options').on('click', '.payment-opt', function() {
                $('#payment-options .payment-opt').removeClass('active');
                $(this).addClass('active').find('input[type=radio]').prop('checked', true);

                let val = $(this).data('value');
                $('#paypal-note').toggle(val === 'paypal');

                if (val === 'stripe') {
                    $('#stripe-card-panel').show();
                    mountStripeCard();
                    $('#stripe-pay-btn').show();
                } else {
                    $('#stripe-card-panel').hide();
                    $('#stripe-pay-btn').hide();
                    $('#stripe-processing').hide();
                }

                if (val === 'paypal') {
                    $('#paypal-button-container').removeClass('pp-hidden');
                    $('#place-order-btn').hide();
                } else {
                    $('#paypal-button-container').addClass('pp-hidden');
                }

                if (val === 'cod' || val === 'bank_transfer') {
                    let label = val === 'cod' ? 'Place Order (Cash on Delivery)' : 'Place Order (Bank Transfer)';
                    $('#place-order-btn').html(`<svg viewBox="0 0 24 24" fill="none" width="20" height="20">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg> ${label}`).show();
                } else {
                    $('#place-order-btn').hide();
                }
            });

            /* Init payment state on load */
            (function initPaymentState() {
                let oldMethod = '{{ old('payment_method', 'paypal') }}';
                if (oldMethod === 'paypal') {
                    $('#paypal-button-container').removeClass('pp-hidden');
                    $('#place-order-btn').hide();
                    $('#stripe-pay-btn').hide();
                    $('#stripe-card-panel').hide();
                    $('#paypal-note').show();
                } else if (oldMethod === 'stripe') {
                    $('#paypal-button-container').addClass('pp-hidden');
                    $('#stripe-card-panel').show();
                    $('#stripe-pay-btn').show();
                    $('#place-order-btn').hide();
                    $('#paypal-note').hide();
                } else if (oldMethod === 'cod' || oldMethod === 'bank_transfer') {
                    $('#paypal-button-container').addClass('pp-hidden');
                    $('#stripe-card-panel').hide();
                    $('#stripe-pay-btn').hide();
                    $('#paypal-note').hide();
                    let label = oldMethod === 'cod' ? 'Place Order (Cash on Delivery)' : 'Place Order (Bank Transfer)';
                    $('#place-order-btn').html(`<svg viewBox="0 0 24 24" fill="none" width="20" height="20">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg> ${label}`).show();
                }
            })();

            /* ═══════════════ BILLING RADIO ═══════════════ */
            $('input[name=billing_type]').on('change', function() {
                $('.billing-opt').removeClass('active');
                $(this).closest('.billing-opt').addClass('active');
            });

            /* ═══════════════ COUNTRY → SHIPPING + TAX ═══════════════ */
            $('#country').on('change', function() {
                currentCountry = $(this).val();
                selectedShippingMethod = null;
                $('#shipping_method_input').val('');
                $('#pobox-warning').hide();
                $('#shipping-cost-row').hide();
                currentShippingCost = 0;
                currentTaxRate = 0;
                currentTaxAmount = 0;
                updateOrderTotal(0);

                if (!currentCountry) {
                    $('#shipping-methods-wrap').hide();
                    $('#shipping-placeholder').show();
                    return;
                }

                $('#shipping-placeholder').hide();
                $('#shipping-methods-wrap').hide();
                $('#shipping-loading').show();

                $.ajax({
                    url: '{{ route('checkout.shipping.methods') }}',
                    method: 'POST',
                    data: {
                        country: currentCountry,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        $('#shipping-loading').hide();
                        if (!res.success || !res.methods.length) {
                            $('#shipping-placeholder').html('<span style="color:var(--clr-error,#e53e3e);">No shipping available for this country.</span>').show();
                            return;
                        }
                        renderShippingMethods(res.methods, '{{ old('shipping_method', '') }}');
                    },
                    error: function() {
                        $('#shipping-loading').hide();
                        showCoToast('error', 'Could not load shipping methods.');
                        $('#shipping-placeholder').show();
                    }
                });

                fetchTaxRate(currentCountry);
            });

            /* ═══════════════ FETCH TAX RATE ═══════════════ */
            function fetchTaxRate(country) {
                $.ajax({
                    url: '{{ route('checkout.tax.rate') }}',
                    method: 'POST',
                    data: {
                        country: country,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        currentTaxRate = parseFloat(res.rate) || 0;
                        updateOrderTotal(currentShippingCost);
                    },
                    error: function() {
                        currentTaxRate = 0;
                        updateOrderTotal(currentShippingCost);
                    }
                });
            }

            /* ═══════════════ RENDER SHIPPING METHODS ═══════════════ */
            function renderShippingMethods(methods, oldMethod) {
                let html = '<div class="ship-method-list">';
                methods.forEach(function(m) {
                    let badge = m.po_box_only ? '<span class="ship-po-badge">PO Box only</span>' : '';
                    html += `<div class="ship-method-opt" data-value="${m.value}" data-cost="${m.cost}" data-pobox="${m.po_box_only ? 1 : 0}">
                        <input type="radio" name="_ship_display" value="${m.value}">
                        <div class="ship-radio-dot"></div>
                        <div class="ship-method-info"><div class="ship-method-label">${m.label} ${badge}</div></div>
                        <div class="ship-method-cost">$${parseFloat(m.cost).toFixed(2)}</div>
                    </div>`;
                });
                html += '</div>';
                $('#shipping-methods-wrap').html(html).show();

                let $toSelect = oldMethod ? $('#shipping-methods-wrap .ship-method-opt[data-value="' + oldMethod + '"]') : null;
                if (!$toSelect || !$toSelect.length) $toSelect = $('#shipping-methods-wrap .ship-method-opt').first();
                selectShippingMethod($toSelect);

                $('#shipping-methods-wrap').on('click', '.ship-method-opt', function() {
                    selectShippingMethod($(this));
                });
            }

            /* ═══════════════ SELECT SHIPPING METHOD ═══════════════ */
            function selectShippingMethod($opt) {
                $('#shipping-methods-wrap .ship-method-opt').removeClass('active');
                $opt.addClass('active').find('input[type=radio]').prop('checked', true);

                selectedShippingMethod = $opt.data('value');
                currentShippingCost = parseFloat($opt.data('cost'));
                let isPoBox = $opt.data('pobox') == 1;

                $('#shipping_method_input').val(selectedShippingMethod);
                isPoBox ? $('#pobox-warning').show() : $('#pobox-warning').hide();
                $('#shipping-cost-value').text('$' + currentShippingCost.toFixed(2));
                $('#shipping-cost-row').show();
                updateOrderTotal(currentShippingCost);
            }

            /* ═══════════════ UPDATE TOTALS ═══════════════ */
            function updateOrderTotal(shippingCost) {
                let discountedSubtotal = Math.max(0, subtotal - appliedDiscount);
                currentTaxAmount = Math.round(discountedSubtotal * currentTaxRate / 100 * 100) / 100;
                let total = discountedSubtotal + shippingCost + currentTaxAmount;

                $('#checkout-subtotal').text('$' + subtotal.toFixed(2));
                $('#checkout-shipping-cost').text(shippingCost > 0 ? '$' + shippingCost.toFixed(2) : 'Select method');

                if (currentTaxRate > 0) {
                    $('#tax-rate-label').text(currentTaxRate);
                    $('#tax-amount-display').text('$' + currentTaxAmount.toFixed(2));
                    $('#tax-row').show();
                } else {
                    $('#tax-row').hide();
                }

                $('#checkout-total').text('$' + total.toFixed(2));
            }

            /* ═══════════════ PO BOX LIVE HINT ═══════════════ */
            $('input[name=address]').on('input', function() {
                if (currentCountry !== 'US' || selectedShippingMethod !== 'economy') return;
                let isPoBox = /\b(P\.?\s*O\.?\s*Box|Post\s*Office\s*Box)\b/i.test($(this).val());
                isPoBox ? $('#pobox-warning').hide() : $('#pobox-warning').show();
            });

            /* ═══════════════ APPLY COUPON ═══════════════ */
            $('#apply-coupon-btn').on('click', function() {
                let code = $('#coupon-input').val().trim();
                if (!code) {
                    showCoToast('warning', 'Please enter a coupon code.');
                    return;
                }

                $.ajax({
                    url: '/coupon/apply',
                    method: 'POST',
                    data: {
                        code,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            appliedDiscount = res.discount_amount;
                            $('#hidden_coupon_code').val($('#coupon-input').val().trim());
                            $('#discount-row').show();
                            $('#discount-amount').text('-$' + appliedDiscount.toFixed(2));
                            updateOrderTotal(currentShippingCost);
                            $('#coupon-message').html(`<span style="color:var(--clr-success);font-size:12.5px;">✓ Coupon applied! You saved $${appliedDiscount.toFixed(2)}</span>`);
                            showCoToast('success', 'Coupon applied! Saved $' + appliedDiscount.toFixed(2));
                        } else {
                            $('#coupon-message').html(`<span style="color:var(--clr-error);font-size:12.5px;">✗ ${res.message ?? 'Invalid coupon.'}</span>`);
                            showCoToast('error', res.message ?? 'Invalid coupon code.');
                        }
                    },
                    error: function() {
                        showCoToast('error', 'Failed to apply coupon.');
                    }
                });
            });

            /* ═══════════════ FORM VALIDATION ═══════════════ */
            function validateForm() {
                if (!selectedShippingMethod) {
                    showCoToast('error', 'Please select a shipping method.');
                    $('#shipping-section').get(0)?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    return false;
                }
                if (currentCountry === 'US' && selectedShippingMethod === 'economy') {
                    let addr = $('input[name=address]').val();
                    if (!/\b(P\.?\s*O\.?\s*Box|Post\s*Office\s*Box)\b/i.test(addr)) {
                        showCoToast('error', 'Economy (USPS) requires a PO Box address.');
                        $('input[name=address]').focus();
                        return false;
                    }
                }
                return true;
            }

            /* ═══════════════ COD / BANK TRANSFER SUBMIT ═══════════════ */
            $('#checkout-form').on('submit', function(e) {
                e.preventDefault();
                if (!validateForm()) return;

                let $btn = $('#place-order-btn');
                $btn.prop('disabled', true).html(`<svg viewBox="0 0 24 24" fill="none" width="20" height="20" style="animation:spin 1s linear infinite">
                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg> Processing…`);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        if (res.success && !res.paypal && !res.stripe) {
                            showCoToast('success', 'Order placed successfully! Redirecting…');
                            setTimeout(() => {
                                window.location.href = res.redirect ?? '/';
                            }, 1800);
                        } else {
                            showCoToast('error', res.message ?? 'Something went wrong.');
                            resetNormalBtn($btn);
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Failed to place order.';
                        if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                        if (xhr.responseJSON?.errors) msg = Object.values(xhr.responseJSON.errors).flat().join(' ');
                        showCoToast('error', msg);
                        resetNormalBtn($btn);
                    }
                });
            });

            function resetNormalBtn($btn) {
                let val = $('input[name=payment_method]:checked').val();
                let label = val === 'cod' ? 'Place Order (Cash on Delivery)' : 'Place Order (Bank Transfer)';
                $btn.prop('disabled', false).html(`<svg viewBox="0 0 24 24" fill="none" width="20" height="20">
                    <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> ${label}`);
            }

            /* ═══════════════ STRIPE PAY ═══════════════ */
            $('#stripe-pay-btn').on('click', async function() {
                if (!validateForm()) return;
                if (!stripeCardEl) {
                    showCoToast('error', 'Card form not ready.');
                    return;
                }

                let $btn = $(this);
                $btn.prop('disabled', true).html(`<svg viewBox="0 0 24 24" fill="none" width="20" height="20" style="animation:spin 1s linear infinite">
                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg> Processing…`);
                $('#stripe-processing').show();

                try {
                    let res = await $.ajax({
                        url: '{{ route('checkout.place.order') }}',
                        method: 'POST',
                        data: $('#checkout-form').serialize()
                    });

                    if (!res.success || !res.stripe || !res.client_secret) {
                        showCoToast('error', res.message ?? 'Could not initiate Stripe payment.');
                        resetStripeBtn($btn);
                        return;
                    }

                    let {
                        error,
                        paymentIntent
                    } = await stripeInstance.confirmCardPayment(res.client_secret, {
                        payment_method: {
                            card: stripeCardEl,
                            billing_details: {
                                name: $('input[name=name]').val(),
                                email: $('input[name=email]').val(),
                                phone: $('input[name=phone]').val(),
                                address: {
                                    line1: $('input[name=address]').val(),
                                    city: $('input[name=city]').val(),
                                    postal_code: $('input[name=postal_code]').val(),
                                    country: $('select[name=country]').val()
                                }
                            }
                        }
                    });

                    if (error) {
                        showCoToast('error', error.message ?? 'Payment failed.');
                        $('#stripe-card-errors').text(error.message).show();
                        resetStripeBtn($btn);
                        return;
                    }

                    if (paymentIntent.status === 'succeeded') {
                        let captureRes = await $.ajax({
                            url: '{{ route('checkout.stripe.capture') }}',
                            method: 'POST',
                            data: {
                                payment_intent_id: paymentIntent.id,
                                order_number: res.order_number,
                                _token: '{{ csrf_token() }}'
                            }
                        });

                        if (captureRes.success) {
                            showCoToast('success', 'Payment successful! Redirecting…');
                            setTimeout(() => {
                                window.location.href = captureRes.redirect;
                            }, 1800);
                        } else {
                            showCoToast('error', captureRes.message ?? 'Capture failed.');
                            resetStripeBtn($btn);
                        }
                    } else {
                        showCoToast('error', 'Payment incomplete. Please try again.');
                        resetStripeBtn($btn);
                    }
                } catch (err) {
                    showCoToast('error', err.responseJSON?.message ?? err.message ?? 'Payment error.');
                    resetStripeBtn($btn);
                }
            });

            function resetStripeBtn($btn) {
                $('#stripe-processing').hide();
                $btn.prop('disabled', false).html(`<svg viewBox="0 0 24 24" fill="none" width="18" height="18">
                    <rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2"/>
                    <path d="M2 10h20" stroke="currentColor" stroke-width="2"/>
                </svg> Pay with Card`);
            }

            /* ═══════════════ PAYPAL ═══════════════ */
            window.addEventListener('load', function() {
                if (typeof paypal === 'undefined') return;

                paypal.Buttons({
                    createOrder: function(data, actions) {
                        if (!validateForm()) return Promise.reject(new Error('Validation failed'));
                        return new Promise(function(resolve, reject) {
                            $.ajax({
                                url: '{{ route('checkout.place.order') }}',
                                method: 'POST',
                                data: $('#checkout-form').serialize(),
                                success: function(res) {
                                    if (res.success && res.paypal && res.paypal_order_id) {
                                        window._ppOrderNumber = res.order_number;
                                        resolve(res.paypal_order_id);
                                    } else {
                                        showCoToast('error', res.message ?? 'Could not initiate PayPal.');
                                        reject(new Error(res.message ?? 'PayPal init failed'));
                                    }
                                },
                                error: function(xhr) {
                                    let msg = xhr.responseJSON?.message ?? 'Server error.';
                                    showCoToast('error', msg);
                                    reject(new Error(msg));
                                }
                            });
                        });
                    },

                    onApprove: function(data, actions) {
                        $('#paypal-button-container').addClass('pp-hidden');
                        $('#paypal-processing').show();
                        return new Promise(function(resolve, reject) {
                            $.ajax({
                                url: '{{ route('checkout.paypal.capture') }}',
                                method: 'POST',
                                data: {
                                    paypal_order_id: data.orderID,
                                    order_number: window._ppOrderNumber,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(res) {
                                    if (res.success) {
                                        showCoToast('success', 'Payment successful! Redirecting…');
                                        setTimeout(() => {
                                            window.location.href = res.redirect;
                                        }, 1800);
                                        resolve();
                                    } else {
                                        showCoToast('error', res.message ?? 'Capture failed.');
                                        $('#paypal-processing').hide();
                                        $('#paypal-button-container').removeClass('pp-hidden');
                                        reject();
                                    }
                                },
                                error: function() {
                                    showCoToast('error', 'Payment capture error. Please contact support.');
                                    $('#paypal-processing').hide();
                                    $('#paypal-button-container').removeClass('pp-hidden');
                                    reject();
                                }
                            });
                        });
                    },

                    onCancel: function() {
                        showCoToast('warning', 'PayPal payment was cancelled.');
                    },
                    onError: function(err) {
                        console.error('PayPal error', err);
                        showCoToast('error', 'A PayPal error occurred. Please try again.');
                    }

                }).render('#paypal-button-container');
            });

            /* ═══════════════ TOAST ═══════════════ */
            function showCoToast(type, msg) {
                let $t = $(`<div class="co-toast ${type}"><span>${msg}</span></div>`);
                $('#co-toast-wrap').append($t);
                setTimeout(() => $t.fadeOut(300, function() {
                    $(this).remove();
                }), 3500);
            }

            /* ═══════════════ AUTO-TRIGGER COUNTRY ═══════════════ */
            if ($('#country').val()) {
                $('#country').trigger('change');
            }

            /* ═══════════════ SELECT2 FOR COUNTRY ═══════════════ */
            $('#country').select2({
                placeholder: 'Select Country',
                allowClear: true,
                width: '100%',
                dropdownParent: $('body'),
            });

            $('#country').on('select2:select select2:clear', function() {
                $(this).trigger('change');
            });

        });
    </script>

@endsection
