@extends('frontend.dashboard')
@section('frontend_title', 'Order Confirmed')
@section('frontend_content')

    <style>
        .success-wrap {
            max-width: 680px;
            margin: 60px auto;
            padding: 0 20px 60px;
        }

        /* ── Checkmark animation ── */
        .success-icon-wrap {
            text-align: center;
            margin-bottom: 28px;
        }

        .success-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #d1fae5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            animation: popIn .4s ease;
        }

        @keyframes popIn {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            80% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-heading {
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            color: #064e3b;
            margin-bottom: 6px;
        }

        .success-sub {
            text-align: center;
            color: #6b7280;
            font-size: 14.5px;
            margin-bottom: 32px;
        }

        /* ── Order meta card ── */
        .order-meta-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px 24px;
            margin-bottom: 24px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        @media (max-width: 520px) {
            .order-meta-card {
                grid-template-columns: 1fr;
            }
        }

        .meta-item {}

        .meta-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #9ca3af;
            margin-bottom: 3px;
        }

        .meta-value {
            font-size: 14.5px;
            font-weight: 600;
            color: #111827;
        }

        .meta-value .badge {
            font-size: 12px;
            padding: 5px 10px 2px;
            border-radius: 5px;
        }

        /* ── Items table ── */
        .order-items-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .oic-header {
            background: #f3f4f6;
            padding: 14px 20px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .oic-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 20px;
            border-bottom: 1px solid #f3f4f6;
        }

        .oic-item:last-child {
            border-bottom: none;
        }

        .oic-thumb {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
            border: 1px solid #e5e7eb;
        }

        .oic-name {
            flex: 1;
            font-size: 14px;
            font-weight: 500;
            color: #111827;
        }

        .oic-qty {
            font-size: 13px;
            color: #6b7280;
        }

        .oic-price {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            min-width: 80px;
            text-align: right;
        }

        /* ── Totals ── */
        .order-totals-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 28px;
        }

        .tot-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #374151;
            padding: 5px 0;
        }

        .tot-row.grand {
            border-top: 1px solid #e5e7eb;
            margin-top: 10px;
            padding-top: 12px;
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        /* ── Address card ── */
        .address-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 28px;
            font-size: 14px;
            color: #374151;
            line-height: 1.7;
        }

        .address-card-title {
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
        }

        /* ── CTA buttons ── */
        .cta-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-primary-dark {
            flex: 1;
            background: #111827;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px 3px;
            font-size: 14.5px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background .2s;
        }

        .btn-primary-dark:hover {
            background: #374151;
            color: #fff;
        }

        .btn-outline-dark-custom {
            flex: 1;
            background: transparent;
            color: #111827;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            padding: 10px 20px 3px;
            font-size: 14.5px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: border-color .2s;
        }

        .btn-outline-dark-custom:hover {
            border-color: #111827;
            color: #111827;
        }

        /* ── Note box ── */
        .note-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 14px 18px 8px;
            font-size: 13px;
            color: #92400e;
            margin-bottom: 28px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }
    </style>

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">{{ $order->order_number }}</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Order Confirmed</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="success-wrap">

        {{-- ── Checkmark ── --}}
        <div class="success-icon-wrap">
            <div class="success-circle">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
                    <path d="M5 13l4 4L19 7" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </div>

        <h1 class="success-heading">Order Confirmed!</h1>
        <p class="success-sub">
            Thank you for your order. We'll send you an update when it's on its way.
        </p>

        {{-- ── Pre-order notice ── --}}
        @if ($order->order_type === 'pre_order' || $order->status === 'pre_order')
            <div style="
        background:#fff8f0;
        border:1.5px solid #f0a060;
        border-radius:10px;
        padding:16px 20px;
        margin-bottom:24px;
        display:flex;
        align-items:center;
        gap:12px;
    ">
                <span style="font-size:28px;">🕐</span>
                <div>
                    <div style="font-weight:700;color:#c0621a;font-size:15px;">
                        Pre-Order Confirmed!
                    </div>

                    <div style="font-size:13px;color:#888;margin-top:4px;">
                        Your pre-order has been received. Items will be shipped on their scheduled date.
                        We'll notify you when your order ships.
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Payment method note ── --}}
        @if ($order->payment_method === 'bank_transfer')
            <div class="note-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;margin-top:2px">
                    <circle cx="12" cy="12" r="10" stroke="#d97706" stroke-width="2" />
                    <path d="M12 8v4M12 16h.01" stroke="#d97706" stroke-width="2" stroke-linecap="round" />
                </svg>
                <span>
                    Please transfer <strong>${{ number_format($order->total, 2) }}</strong> to our bank account
                    and send the transaction screenshot to confirm your order.
                </span>
            </div>
        @elseif ($order->payment_method === 'cod')
            <div class="note-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;margin-top:2px">
                    <circle cx="12" cy="12" r="10" stroke="#d97706" stroke-width="2" />
                    <path d="M12 8v4M12 16h.01" stroke="#d97706" stroke-width="2" stroke-linecap="round" />
                </svg>
                <span>
                    Please keep <strong>${{ number_format($order->total, 2) }}</strong> ready for cash on delivery.
                </span>
            </div>
        @elseif ($order->payment_method === 'stripe')
            <div class="note-box" style="background:#f0f7ff;border-color:#bfdbfe;color:#1e40af;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;margin-top:2px">
                    <rect x="2" y="5" width="20" height="14" rx="2" stroke="#1e40af" stroke-width="2" />
                    <path d="M2 10h20" stroke="#1e40af" stroke-width="2" />
                </svg>
                <span>
                    Your card payment of <strong>${{ number_format($order->total, 2) }}</strong> was processed successfully.
                    A receipt has been sent to <strong>{{ $order->email }}</strong>.
                </span>
            </div>
        @endif

        {{-- ── Order meta ── --}}
        <div class="order-meta-card">
            <div class="meta-item">
                <div class="meta-label">Order Number</div>
                <div class="meta-value">{{ $order->order_number }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Date</div>
                <div class="meta-value">{{ $order->created_at->format('d M Y, h:i A') }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Payment</div>
                <div class="meta-value">
                    @php
                        $pm = ['paypal' => 'PayPal', 'cod' => 'Cash on Delivery', 'bank_transfer' => 'Bank Transfer', 'stripe' => 'Stripe'];
                    @endphp
                    {{ $pm[$order->payment_method] ?? $order->payment_method }}
                </div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Status</div>
                <div class="meta-value">
                    <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
        </div>

        {{-- ── Order items ── --}}
        <div class="order-items-card">
            <div class="oic-header">Items in your order ({{ $order->items->count() }})</div>
            @foreach ($order->items as $item)
                <div class="oic-item">
                    <img class="oic-thumb" src="{{ $item->product?->cover_image ? asset('upload/product_covers/' . $item->product->cover_image) : asset('upload/no_image.jpg') }}" alt="{{ $item->product_name }}">
                    <div class="oic-name">
                        {{ $item->product_name }}
                        @if ($item->variant_size || $item->variant_color)
                            <br><small class="text-muted">{{ $item->variant_size }} {{ $item->variant_color }}</small>
                        @endif
                    </div>
                    <div class="oic-qty">× {{ $item->quantity }}</div>
                    <div class="oic-price">${{ number_format($item->subtotal ?? $item->price * $item->quantity, 2) }}</div>
                </div>
            @endforeach
        </div>

        {{-- ── Totals ── --}}
        <div class="order-totals-card">
            <div class="tot-row">
                <span>Subtotal</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if ($order->discount > 0)
                <div class="tot-row" style="color:#059669;">
                    <span>Discount @if ($order->coupon_code)
                            ({{ $order->coupon_code }})
                        @endif
                    </span>
                    <span>-${{ number_format($order->discount, 2) }}</span>
                </div>
            @endif
            <div class="tot-row">
                <span>Shipping ({{ $order->shipping_method }})</span>
                <span>${{ number_format($order->shipping_cost, 2) }}</span>
            </div>
            @if (($order->tax ?? 0) > 0)
                <div class="tot-row" style="color:#374151;">
                    <span>Tax ({{ number_format($order->tax_rate ?? 0, 0) }}%)</span>
                    <span>${{ number_format($order->tax, 2) }}</span>
                </div>
            @endif
            <div class="tot-row grand">
                <span>Total</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        {{-- ── Shipping address ── --}}
        <div class="address-card">
            <div class="address-card-title">Shipping Address</div>
            {{ $order->name }}<br>
            {{ $order->address }}, {{ $order->city }}
            @if ($order->postal_code)
                , {{ $order->postal_code }}
            @endif
            <br>
            {{ $order->country_name }}<br>
            {{ $order->phone }}
        </div>

        {{-- ── CTA ── --}}
        <div class="cta-row">
            <a href="{{ url('/') }}" class="btn-outline-dark-custom">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-top: -6px;">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Back to Home
            </a>
            <a href="{{ url('/shop') }}" class="btn-primary-dark">
                Continue Shopping
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-top: -6px;">
                    <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

    </div>

@endsection
