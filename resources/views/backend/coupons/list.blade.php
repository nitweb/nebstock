@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Coupon List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.coupon.add') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Coupon
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Table --}}
            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body">

                            <div class="table-responsive">

                                <table id="datatable-buttons" class="table table-bordered w-100">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Min. Amount</th>
                                            <th>Usage</th>
                                            <th>Expiry</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($coupons as $index => $coupon)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><strong>{{ $coupon->coupon_code }}</strong></td>
                                                <td>
                                                    <span class="badge bg-{{ $coupon->coupon_type === 'percent' ? 'info' : 'secondary' }}">
                                                        {{ ucfirst($coupon->coupon_type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $coupon->coupon_type === 'percent' ? $coupon->coupon_value . '%' : '$' . number_format($coupon->coupon_value, 2) }}
                                                </td>
                                                <td>${{ number_format($coupon->minimum_amount, 2) }}</td>
                                                <td>
                                                    {{ $coupon->used_count }}
                                                    / {{ $coupon->usage_limit ?? '∞' }}
                                                </td>
                                                <td>
                                                    @if ($coupon->end_date)
                                                        {{ $coupon->end_date->format('d M Y') }}
                                                        @if ($coupon->end_date->isPast())
                                                            <span class="badge bg-danger ms-1">Expired</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">No limit</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $coupon->id }}" data-model="{{ \App\Models\Coupon::class }}" data-field="status" data-active="active" data-inactive="inactive" {{ $coupon->status === 'active' ? 'checked' : '' }}>
                                                    </div>
                                                </td>

                                                <td>
                                                    {{-- Edit --}}
                                                    <a href="{{ route('backend.coupon.edit', $coupon->id) }}" class="btn btn-sm btn-outline-info waves-effect waves-light mb-2">
                                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <a href="{{ route('backend.coupon.delete', $coupon->id) }}" onclick="return confirm('Delete this coupon?')" class="btn btn-sm btn-outline-danger waves-effect waves-light mb-2">
                                                        <i class="bx bxs-trash font-size-16 align-middle"></i>
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
