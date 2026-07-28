@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Order List</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order No</th>
                                            <th>Customer</th>
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
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $order->order_number }}</strong></td>
                                                <td>
                                                    {{ $order->user->name ?? $order->name }}<br>
                                                    <small class="text-muted">{{ $order->phone }}</small>
                                                </td>
                                                <td>{{ $order->items->count() }} item(s)</td>
                                                <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                                <td>
                                                    <span class="badge bg-{{ $order->payment_status_color }}">
                                                        {{ ucfirst($order->payment_status ?? 'pending') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $order->status_color }}">
                                                        {{ $order->status_label }}
                                                    </span>
                                                </td>
                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                <td>
                                                    {{-- View --}}
                                                    <a href="{{ route('backend.orders.detail', $order->id) }}" class="btn btn-sm btn-outline-info mb-1" title="View Order">
                                                        <i class="bx bx-show"></i>
                                                    </a>

                                                    {{-- Download Invoice --}}
                                                    <a href="{{ route('backend.orders.invoice', $order->id) }}" class="btn btn-sm btn-outline-success mb-1" title="Download Invoice" target="_blank">
                                                        <i class="bx bxs-download"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <a href="{{ route('backend.orders.delete', $order->id) }}" onclick="return confirm('Delete this order?')" class="btn btn-sm btn-outline-danger mb-1" title="Delete Order">
                                                        <i class="bx bxs-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
