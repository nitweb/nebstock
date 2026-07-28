<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 13px;
            color: #2d2d2d;
            background: #fff;
            line-height: 1.5;
        }

        /* ── Page wrapper ─────────────────────────── */
        .page {
            padding: 40px 48px;
        }

        /* ── Header ──────────────────────────────── */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 36px;
            border-bottom: 3px solid #1a1a2e;
            padding-bottom: 24px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
            text-align: right;
        }

        .logo {
            max-height: 60px;
            max-width: 180px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            letter-spacing: 0.5px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .invoice-number {
            font-size: 13px;
            color: #666;
            margin-top: 4px;
        }

        /* ── Meta strip ──────────────────────────── */
        .meta-strip {
            display: table;
            width: 100%;
            margin-bottom: 28px;
            background: #f8f9fc;
            border-radius: 6px;
            padding: 14px 20px;
        }

        .meta-item {
            display: table-cell;
            text-align: center;
        }

        .meta-item+.meta-item {
            border-left: 1px solid #e0e0e0;
        }

        .meta-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            display: block;
            margin-bottom: 3px;
        }

        .meta-value {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
        }

        /* ── Address block ───────────────────────── */
        .address-row {
            display: table;
            width: 100%;
            margin-bottom: 28px;
        }

        .address-col {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
            padding-right: 16px;
        }

        .address-col:last-child {
            padding-right: 0;
        }

        .address-box {
            border: 1px solid #e8e8e8;
            border-radius: 6px;
            padding: 14px 16px;
        }

        .address-heading {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #efefef;
        }

        .address-name {
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .address-text {
            color: #555;
            font-size: 12px;
            line-height: 1.6;
        }

        /* ── Items table ──────────────────────────── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .items-table thead tr {
            background: #1a1a2e;
            color: #fff;
        }

        .items-table thead th {
            padding: 11px 14px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 600;
        }

        .items-table thead th:last-child,
        .items-table tbody td:last-child {
            text-align: right;
        }

        .items-table thead th.center,
        .items-table tbody td.center {
            text-align: center;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        .items-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .items-table tbody td {
            padding: 11px 14px;
            color: #2d2d2d;
            vertical-align: top;
        }

        .product-name {
            font-weight: 600;
            color: #1a1a2e;
        }

        .product-sku {
            font-size: 11px;
            color: #999;
            margin-top: 2px;
        }

        /* ── Totals ───────────────────────────────── */
        .totals-wrapper {
            display: table;
            width: 100%;
            margin-bottom: 32px;
        }

        .totals-spacer {
            display: table-cell;
            width: 55%;
        }

        .totals-box {
            display: table-cell;
            width: 45%;
            vertical-align: top;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table tr td {
            padding: 7px 14px;
            font-size: 13px;
        }

        .totals-table tr td:first-child {
            color: #666;
        }

        .totals-table tr td:last-child {
            text-align: right;
            font-weight: 500;
            color: #2d2d2d;
        }

        .totals-table tr.divider td {
            border-top: 1px solid #e8e8e8;
            padding-top: 10px;
        }

        .totals-table tr.total-row {
            background: #1a1a2e;
            border-radius: 4px;
        }

        .totals-table tr.total-row td {
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            padding: 10px 14px;
        }

        /* ── Badges ───────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-warning {
            background: #fff8e1;
            color: #f57c00;
        }

        .badge-danger {
            background: #fce4ec;
            color: #c62828;
        }

        .badge-primary {
            background: #e3f2fd;
            color: #1565c0;
        }

        .badge-info {
            background: #e0f7fa;
            color: #00796b;
        }

        .badge-secondary {
            background: #f5f5f5;
            color: #555;
        }

        /* ── Payment info ─────────────────────────── */
        .payment-row {
            display: table;
            width: 100%;
            margin-bottom: 28px;
        }

        .payment-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .info-box {
            border: 1px solid #e8e8e8;
            border-radius: 6px;
            padding: 14px 16px;
            margin-right: 12px;
        }

        .info-box:last-child {
            margin-right: 0;
        }

        .info-box-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #efefef;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }

        .info-key {
            display: table-cell;
            color: #888;
            font-size: 12px;
            width: 50%;
        }

        .info-val {
            display: table-cell;
            color: #2d2d2d;
            font-size: 12px;
            font-weight: 600;
            text-align: right;
        }

        /* ── Notes ────────────────────────────────── */
        .notes-box {
            border-left: 4px solid #1a1a2e;
            padding: 10px 16px;
            background: #f8f9fc;
            border-radius: 0 6px 6px 0;
            margin-bottom: 28px;
        }

        .notes-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 4px;
        }

        .notes-text {
            color: #444;
            font-size: 12px;
        }

        /* ── Footer ───────────────────────────────── */
        .footer {
            border-top: 1px solid #e8e8e8;
            padding-top: 16px;
            text-align: center;
            color: #aaa;
            font-size: 11px;
            line-height: 1.7;
        }

        .footer strong {
            color: #666;
        }

        .thank-you {
            text-align: center;
            margin-bottom: 20px;
        }

        .thank-you p {
            font-size: 15px;
            color: #1a1a2e;
            font-weight: 600;
        }

        .thank-you small {
            color: #888;
            font-size: 12px;
        }
    </style>
</head>

<body>
    @php
        $countries = [
            'AT' => 'Austria',
            'BE' => 'Belgium',
            'BG' => 'Bulgaria',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DE' => 'Germany',
            'DK' => 'Denmark',
            'EE' => 'Estonia',
            'EL' => 'Greece',
            'GR' => 'Greece',
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
        ];
    @endphp
    <div class="page">

        {{-- ── HEADER ──────────────────────────────────── --}}
        <div class="header">
            <div class="header-left">
                @if (!empty($settings->site_header_logo))
                    <img src="{{ public_path($settings->site_header_logo) }}" class="logo" alt="Logo">
                @else
                    <div class="brand-name">{{ config('app.name', 'Nicole Murray') }}</div>
                @endif
                @if (!empty($settings->site_address))
                    <div style="color:#666;font-size:11px;margin-top:6px;">
                        {{ $settings->site_address }}
                    </div>
                @endif
                @if (!empty($settings->site_email))
                    <div style="color:#888;font-size:11px;">{{ $settings->site_email }}</div>
                @endif
                @if (!empty($settings->site_phone))
                    <div style="color:#888;font-size:11px;">{{ $settings->site_phone }}</div>
                @endif
            </div>
            <div class="header-right">
                <div class="invoice-title">Invoice</div>
                <div class="invoice-number"># {{ $order->order_number }}</div>
            </div>
        </div>

        {{-- ── META STRIP ──────────────────────────────── --}}
        <div class="meta-strip">
            <div class="meta-item">
                <span class="meta-label">Invoice Date</span>
                <span class="meta-value">{{ $order->created_at->format('d M Y') }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Order Status</span>
                <span class="meta-value">
                    <span class="badge badge-{{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Payment Status</span>
                <span class="meta-value">
                    <span class="badge badge-{{ $order->payment_status_color }}">
                        {{ ucfirst($order->payment_status ?? 'pending') }}
                    </span>
                </span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Payment Method</span>
                <span class="meta-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? '—')) }}</span>
            </div>
        </div>

        {{-- ── BILLING / SHIPPING ADDRESS ─────────────── --}}
        <div class="address-row">
            {{-- Billing --}}
            <div class="address-col">
                <div class="address-box">
                    <div class="address-heading">Billed To</div>
                    <div class="address-name">{{ $order->user->name ?? $order->name }}</div>
                    <div class="address-text">
                        @if ($order->email)
                            {{ $order->email }}<br>
                        @endif
                        @if ($order->phone)
                            {{ $order->phone }}<br>
                        @endif
                        @if ($order->company)
                            {{ $order->company }}<br>
                        @endif
                        {{ $order->address }}<br>
                        {{ $order->city }}@if ($order->postal_code)
                            , {{ $order->postal_code }}
                        @endif
                        <br>
                        {{ $countries[$order->country] ?? $order->country_name }}
                    </div>
                </div>
            </div>

            {{-- Shipping --}}
            <div class="address-col">
                <div class="address-box">
                    <div class="address-heading">Shipped To</div>
                    @if ($order->billing_type === 'same')
                        <div class="address-name">{{ $order->user->name ?? $order->name }}</div>
                        <div class="address-text">
                            {{ $order->address }}<br>
                            {{ $order->city }}@if ($order->postal_code)
                                , {{ $order->postal_code }}
                            @endif
                            <br>
                            {{ $countries[$order->country] ?? $order->country_name }}
                        </div>
                    @else
                        <div class="address-name">
                            {{ trim(($order->ship_first_name ?? '') . ' ' . ($order->ship_last_name ?? '')) ?: $order->user->name ?? $order->name }}
                        </div>
                        <div class="address-text">
                            @if ($order->ship_address)
                                {{ $order->ship_address }}<br>
                            @endif
                            {{ $order->ship_city }}@if ($order->ship_postal)
                                , ', '.$order->ship_postal
                            @endif
                            <br>
                            {{ $countries[$order->ship_country] ?? $order->ship_country }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Order info --}}
            <div class="address-col" style="padding-right:0;">
                <div class="address-box">
                    <div class="address-heading">Order Info</div>
                    <div class="info-row">
                        <span class="info-key">Order Type</span>
                        <span class="info-val">{{ ucfirst($order->order_type ?? 'normal') }}</span>
                    </div>
                    @if ($order->shipping_method)
                        <div class="info-row">
                            <span class="info-key">Shipping</span>
                            <span class="info-val">{{ $order->shipping_method }}</span>
                        </div>
                    @endif
                    @if ($order->transaction_id)
                        <div class="info-row">
                            <span class="info-key">Transaction</span>
                            <span class="info-val" style="font-size:11px;">{{ $order->transaction_id }}</span>
                        </div>
                    @endif
                    <div class="info-row" style="margin-top:8px;">
                        <span class="info-key">Items</span>
                        <span class="info-val">{{ $order->items->count() }} item(s)</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── ORDER ITEMS TABLE ────────────────────────── --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:5%;">#</th>
                    <th style="width:40%;">Product</th>
                    <th class="center" style="width:15%;">Qty</th>
                    <th class="center" style="width:20%;">Unit Price</th>
                    <th style="width:20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="product-name">{{ $item->product_name }}</div>
                            @if ($item->product?->sku)
                                <div class="product-sku">SKU: {{ $item->product->sku }}</div>
                            @endif
                        </td>
                        <td class="center">{{ $item->quantity }}</td>
                        <td class="center">${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ── TOTALS ───────────────────────────────────── --}}
        <div class="totals-wrapper">
            <div class="totals-spacer"></div>
            <div class="totals-box">
                <table class="totals-table">
                    <tr>
                        <td>Subtotal</td>
                        <td>${{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    @if ($order->discount > 0)
                        <tr>
                            <td>Discount</td>
                            <td style="color:#c62828;">- ${{ number_format($order->discount, 2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>Shipping</td>
                        <td>
                            @if ($order->shipping_cost > 0)
                                ${{ number_format($order->shipping_cost, 2) }}
                            @else
                                <span style="color:#2e7d32;">Free</span>
                            @endif
                        </td>
                    </tr>
                    @if (($order->tax ?? 0) > 0)
                        <tr>
                            <td>Tax ({{ number_format($order->tax_rate ?? 0, 0) }}%)</td>
                            <td>${{ number_format($order->tax, 2) }}</td>
                        </tr>
                    @endif
                    <tr class="divider">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="total-row">
                        <td>Total</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- ── ORDER NOTES ──────────────────────────────── --}}
        @if ($order->order_notes)
            <div class="notes-box">
                <div class="notes-title">Order Notes</div>
                <div class="notes-text">{{ $order->order_notes }}</div>
            </div>
        @endif

        {{-- ── THANK YOU ────────────────────────────────── --}}
        <div class="thank-you">
            <p>Thank you for your order!</p>
            <small>We appreciate your business and hope to see you again soon.</small>
        </div>

        {{-- ── FOOTER ───────────────────────────────────── --}}
        <div class="footer">
            @if (!empty($settings->site_email))
                <strong>{{ $settings->site_email }}</strong> &nbsp;|&nbsp;
            @endif
            @if (!empty($settings->site_phone))
                {{ $settings->site_phone }} &nbsp;|&nbsp;
            @endif
            @if (!empty($settings->site_address))
                {{ $settings->site_address }}
            @endif
            <br>
            {{ $settings->site_copyright ?? '© ' . date('Y') . ' ' . config('app.name', 'Nicole Murray') . '. All rights reserved.' }}
            <br>
            <span style="font-size:10px; color:#ccc;">Generated on {{ now()->format('d M Y, h:i A') }}</span>
        </div>

    </div>
</body>

</html>
