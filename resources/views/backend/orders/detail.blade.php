@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Order: {{ $order->order_number }}</h4>
                        <div class="page-title-right">
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-undo me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                {{-- ── Left col ── --}}
                <div class="col-lg-8">

                    {{-- Items --}}
                    <div class="card mb-3">
                        <div class="card-header fw-semibold">Order Items</div>
                        <div class="card-body p-0">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Type</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $item->product?->cover_image ? asset('upload/product_covers/' . $item->product->cover_image) : asset('upload/no_image.jpg') }}" style="width:40px;height:40px;object-fit:cover;border-radius:6px;" alt="">
                                                    <div>
                                                        {{-- product_name accessor থেকে আসে --}}
                                                        {{ $item->product_name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $item->product?->product_type ?? '—' }}
                                                </span>
                                            </td>
                                            <td>${{ number_format($item->unit_price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td class="text-end fw-bold">${{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="4" class="text-end">Subtotal</td>
                                        <td class="text-end fw-bold">${{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    @if ($order->discount_amount > 0)
                                        <tr>
                                            <td colspan="4" class="text-end text-success">Discount</td>
                                            <td class="text-end text-success">-${{ number_format($order->discount_amount, 2) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="4" class="text-end">
                                            Shipping{{ $order->shipping_method ? ' (' . $order->shipping_method . ')' : '' }}
                                        </td>
                                        <td class="text-end">${{ number_format($order->shipping_cost, 2) }}</td>
                                    </tr>
                                    @if (($order->tax ?? 0) > 0)
                                        <tr>
                                            <td colspan="4" class="text-end">Tax ({{ number_format($order->tax_rate ?? 0, 0) }}%)</td>
                                            <td class="text-end">${{ number_format($order->tax, 2) }}</td>
                                        </tr>
                                    @endif
                                    <tr class="fw-bold">
                                        <td colspan="4" class="text-end">Total</td>
                                        <td class="text-end">${{ number_format($order->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Addresses --}}
                    <div class="card mb-3">
                        <div class="card-header fw-semibold">Addresses</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 fw-semibold text-muted small text-uppercase">Shipping Address</p>
                                    <p class="mb-0">
                                        {{ $order->shipping_name }}<br>
                                        @if ($order->shipping_company)
                                            {{ $order->shipping_company }}<br>
                                        @endif
                                        {{ $order->shipping_address }}<br>
                                        {{ $order->shipping_city }}@if ($order->shipping_postal_code)
                                            , {{ $order->shipping_postal_code }}
                                        @endif
                                        <br>
                                        {{ $order->country_name }}<br>
                                        <strong>{{ $order->phone }}</strong>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 fw-semibold text-muted small text-uppercase">Billing Address</p>
                                    @if ($order->billing_type === 'same')
                                        <p class="mb-0 text-muted">Same as shipping address</p>
                                    @else
                                        <p class="mb-0">
                                            {{ $order->ship_first_name }} {{ $order->ship_last_name }}<br>
                                            {{ $order->ship_address }}<br>
                                            {{ $order->ship_city }}@if ($order->ship_postal)
                                                , {{ $order->ship_postal }}
                                            @endif
                                            <br>
                                            {{ $order->ship_country }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->order_notes)
                        <div class="card">
                            <div class="card-header fw-semibold">Order Notes</div>
                            <div class="card-body">{{ $order->order_notes }}</div>
                        </div>
                    @endif

                </div>

                {{-- ── Right col ── --}}
                <div class="col-lg-4">

                    {{-- Order status --}}
                    <div class="card mb-3">
                        <div class="card-header fw-semibold">Order Status</div>
                        <div class="card-body">
                            <p>
                                Current:
                                <span class="badge bg-{{ $order->status_color }}">{{ $order->status_label }}</span>
                            </p>
                            <form action="{{ route('backend.orders.status.update', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" class="form-select form-select-sm mb-2">
                                    @foreach ($statuses as $val => $label)
                                        <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-primary w-100">Update Status</button>
                            </form>
                        </div>
                    </div>

                    {{-- Payment --}}
                    <div class="card mb-3">
                        <div class="card-header fw-semibold">Payment</div>
                        <div class="card-body">
                            @php
                                $pm = ['paypal' => 'PayPal', 'cod' => 'Cash on Delivery', 'bank_transfer' => 'Bank Transfer'];
                            @endphp
                            <p>
                                Method: <strong>{{ $pm[$order->payment_method] ?? $order->payment_method }}</strong><br>
                                Status: <span class="badge bg-{{ $order->payment_status_color }}">{{ ucfirst($order->payment_status ?? 'pending') }}</span>
                            </p>
                            <form action="{{ route('backend.orders.payment.status.update', $order->id) }}" method="POST">
                                @csrf
                                <select name="payment_status" class="form-select form-select-sm mb-2">
                                    @foreach (['pending', 'paid', 'failed', 'refunded'] as $ps)
                                        <option value="{{ $ps }}" {{ ($order->payment_status ?? 'pending') === $ps ? 'selected' : '' }}>
                                            {{ ucfirst($ps) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-success w-100">Update Payment</button>
                            </form>
                        </div>
                    </div>

                    {{-- Customer --}}
                    <div class="card">
                        <div class="card-header fw-semibold">Customer</div>
                        <div class="card-body">
                            <p class="mb-1"><strong>{{ $order->user->name ?? $order->name }}</strong></p>
                            <p class="mb-1 text-muted small">{{ $order->email }}</p>
                            <p class="mb-0 text-muted small">{{ $order->phone }}</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
