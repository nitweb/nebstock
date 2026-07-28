@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Page Title --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Customer Detail</h4>
                        <div class="page-title-right d-flex gap-2">
                            <a href="{{ route('backend.customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-warning waves-effect">
                                <i class="bx bx-edit font-size-16 align-middle me-1"></i> Edit
                            </a>
                            <a href="{{ route('backend.customers.list') }}" class="btn btn-sm btn-outline-primary waves-effect">
                                <i class="bx bx-list-ul font-size-16 align-middle me-1"></i> All Customers
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect">
                                <i class="bx bx-undo font-size-16 align-middle me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                {{-- Left: Profile Card --}}
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body text-center pt-4">
                            <img src="{{ asset('upload/customer_images/' . ($customer->photo ?? 'avatar.png')) }}" alt="{{ $customer->name }}" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;border:4px solid #e9ecef;">

                            <h5 class="mb-1">{{ $customer->name }}</h5>
                            <p class="text-muted mb-2">{{ $customer->email }}</p>

                            <span class="badge {{ $customer->status == '1' ? 'bg-success' : 'bg-secondary' }} font-size-12 mb-3">
                                {{ $customer->status == '1' ? 'Active' : 'Inactive' }}
                            </span>

                            <hr>

                            <table class="table table-borderless table-sm text-start mb-0">
                                <tr>
                                    <th class="text-muted" style="width:40%">Phone</th>
                                    <td>{{ $customer->phone ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Address</th>
                                    <td>{{ $customer->address ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Joined</th>
                                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                                </tr>
                            </table>

                            <hr>

                            <div class="d-flex gap-2 justify-content-center">
                                <button class="btn btn-sm toggle-status-btn {{ $customer->status == '1' ? 'btn-warning' : 'btn-success' }}" data-id="{{ $customer->id }}">
                                    {{ $customer->status == '1' ? 'Deactivate' : 'Activate' }}
                                </button>
                                <a href="{{ route('backend.customers.delete', $customer->id) }}" onclick="return confirm('Permanently delete this customer?')" class="btn btn-sm btn-danger">
                                    <i class="bx bxs-trash me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Summary Stats --}}
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card mini-stats-wid">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <div class="avatar-sm rounded bg-primary bg-soft d-flex align-items-center justify-content-center" style="min-width:48px;height:48px;">
                                        <i class="fas fa-shopping-cart font-size-24 text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 font-size-13">Total Orders</p>
                                        <h5 class="mb-0">{{ $totalOrders }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mini-stats-wid">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <div class="avatar-sm rounded bg-success bg-soft d-flex align-items-center justify-content-center" style="min-width:48px;height:48px;">
                                        <i class="bx bx-dollar font-size-24 text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 font-size-13">Total Spent (Paid)</p>
                                        <h5 class="mb-0">${{ number_format($totalSpent, 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mini-stats-wid">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <div class="avatar-sm rounded bg-warning bg-soft d-flex align-items-center justify-content-center" style="min-width:48px;height:48px;">
                                        <i class="bx bx-time font-size-24 text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 font-size-13">Pending Orders</p>
                                        <h5 class="mb-0">{{ $pendingOrders }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Order History --}}
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0 font-size-15">
                                <i class="bx bx-list-check me-2 text-primary"></i>
                                Order History
                                <span class="badge bg-primary ms-2">{{ $totalOrders }}</span>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if ($orders->isEmpty())
                                <div class="text-center py-5 text-muted">
                                    <i class="bx bx-package font-size-40 d-block mb-2"></i>
                                    No orders found for this customer.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order #</th>
                                                <th>Items</th>
                                                <th>Total</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td><strong>#{{ $order->order_number }}</strong></td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border">
                                                            {{ $order->items->count() }}
                                                            {{ Str::plural('item', $order->items->count()) }}
                                                        </span>
                                                        {{-- @if ($order->items->isNotEmpty())
                                                            <div class="text-muted small mt-1" style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                                {{ $order->items->pluck('name')->join(', ') }}
                                                            </div>
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        <strong>${{ number_format($order->total, 2) }}</strong>
                                                        {{-- @if ($order->discount > 0)
                                                            <div class="text-muted small">
                                                                -${{ number_format($order->discount, 2) }} off
                                                            </div>
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $order->payment_status_color ?? 'secondary' }}">
                                                            {{ ucfirst($order->payment_status ?? 'pending') }}
                                                        </span>
                                                        <div class="text-muted small">
                                                            {{ strtoupper($order->payment_method ?? '') }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $order->status_color }}">
                                                            {{ $order->status_label }}
                                                        </span>
                                                    </td>
                                                    <td class="text-nowrap">
                                                        {{ $order->created_at->format('d M Y') }}
                                                        <div class="text-muted small">
                                                            {{ $order->created_at->format('h:i A') }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('backend.orders.detail', $order->id) }}" class="btn btn-sm btn-outline-info waves-effect" title="View Order">
                                                            <i class="bx bx-show align-middle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- ── Pagination: theme rounded style, no giant SVG arrows ──────── --}}
                                @if ($orders->hasPages())
                                    <div class="p-3">
                                        <ul class="pagination pagination-rounded justify-content-center mb-1">

                                            {{-- Prev --}}
                                            <li class="page-item {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $orders->previousPageUrl() ?? '#' }}">
                                                    <i class="mdi mdi-chevron-left"></i>
                                                </a>
                                            </li>

                                            {{-- Page numbers --}}
                                            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                                <li class="page-item {{ $orders->currentPage() === $page ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach

                                            {{-- Next --}}
                                            <li class="page-item {{ !$orders->hasMorePages() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $orders->nextPageUrl() ?? '#' }}">
                                                    <i class="mdi mdi-chevron-right"></i>
                                                </a>
                                            </li>

                                        </ul>
                                        <p class="text-center text-muted small mb-0">
                                            Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }}
                                            of {{ $orders->total() }} results
                                        </p>
                                    </div>
                                @endif

                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('click', async function(e) {
            const btn = e.target.closest('.toggle-status-btn');
            if (!btn) return;
            btn.disabled = true;

            try {
                const res = await fetch('{{ route('backend.customers.toggle_status') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        id: btn.dataset.id
                    }),
                });
                const data = await res.json();

                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(() => location.reload(), 900);
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                    btn.disabled = false;
                }
            } catch {
                toastr.error('Network error.');
                btn.disabled = false;
            }
        });
    </script>
@endsection
