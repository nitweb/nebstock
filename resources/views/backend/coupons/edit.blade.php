@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Coupon — <strong>{{ $coupon->coupon_code }}</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.coupon.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Coupon List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Form --}}
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form class="g-3" action="{{ route('backend.coupon.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $coupon->id }}">

                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="coupon_code" id="coupon_code" class="form-control text-uppercase @error('coupon_code') is-invalid @enderror" value="{{ old('coupon_code', $coupon->coupon_code) }}" required>
                                            <button class="btn btn-outline-secondary" type="button" id="generate-btn">Generate</button>
                                        </div>
                                        @error('coupon_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-select">
                                            <option value="active" {{ old('status', $coupon->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $coupon->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Coupon Type <span class="text-danger">*</span></label>
                                        <select name="coupon_type" id="coupon_type" class="form-select">
                                            <option value="fixed" {{ old('coupon_type', $coupon->coupon_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                            <option value="percent" {{ old('coupon_type', $coupon->coupon_type) == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Discount Value <span class="text-danger">*</span>
                                            <small class="text-muted" id="value-hint">
                                                {{ $coupon->coupon_type === 'percent' ? '(in %)' : '(in $)' }}
                                            </small>
                                        </label>
                                        <input type="number" name="coupon_value" step="0.01" min="0" class="form-control @error('coupon_value') is-invalid @enderror" value="{{ old('coupon_value', $coupon->coupon_value) }}" required>
                                        @error('coupon_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Minimum Order Amount ($)</label>
                                        <input type="number" name="minimum_amount" step="0.01" min="0" class="form-control" value="{{ old('minimum_amount', $coupon->minimum_amount) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Usage Limit
                                            <small class="text-muted">(Used: {{ $coupon->used_count }})</small>
                                        </label>
                                        <input type="number" name="usage_limit" min="1" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}" placeholder="Blank = unlimited">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date?->format('Y-m-d')) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">End Date (Expiry)</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $coupon->end_date?->format('Y-m-d')) }}">
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Update Coupon</button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('coupon_type').addEventListener('change', function() {
            document.getElementById('value-hint').textContent = this.value === 'percent' ? '(in %)' : '(in $)';
        });

        document.getElementById('generate-btn').addEventListener('click', function() {
            fetch('{{ route('backend.coupon.generate') }}')
                .then(r => r.json())
                .then(d => {
                    document.getElementById('coupon_code').value = d.code;
                });
        });
    </script>

    @include('admin.layout.custom_scripts')

    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('alert-type') === 'success')
                    toastr.success('{{ session('message') }}');
                @elseif (session('alert-type') === 'error')
                    toastr.error('{{ session('message') }}');
                @else
                    toastr.info('{{ session('message') }}');
                @endif
            });
        </script>
    @endif
@endsection
