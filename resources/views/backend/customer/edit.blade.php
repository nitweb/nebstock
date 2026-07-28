@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Customer</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.customers.detail', $customer->id) }}" class="btn btn-sm btn-outline-info waves-effect waves-light">
                                <i class="bx bx-show font-size-16 align-middle me-2"></i> View Orders
                            </a>
                            <a href="{{ route('backend.customers.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Customer List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form class="row g-3" action="{{ route('backend.customers.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $customer->id }}">

                                {{-- Photo --}}
                                <div class="col-md-8">
                                    <label class="form-label">Profile Photo <small class="text-muted">[300×300px]</small></label>
                                    <input type="file" class="form-control" name="photo" id="photoInput" accept="image/*">
                                    <img id="showImage" src="{{ $customer->photo && $customer->photo !== 'avatar.png' ? url('upload/customer_images/' . $customer->photo) : asset('upload/no_image.jpg') }}" alt="Customer Photo" class="p-1 bg-primary mt-3" style="width:110px;height:110px;object-fit:cover;border-radius:8px;">
                                </div>

                                {{-- Name --}}
                                <div class="col-md-8">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $customer->name) }}" required>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-8">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $customer->email) }}" required>
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-8">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $customer->phone) }}">
                                </div>

                                {{-- Address --}}
                                <div class="col-md-8">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3">{{ old('address', $customer->address) }}</textarea>
                                </div>

                                {{-- New Password (optional) --}}
                                <div class="col-md-8">
                                    <label class="form-label">
                                        New Password
                                        <small class="text-muted">(leave blank to keep current)</small>
                                    </label>
                                    <input type="password" class="form-control" name="password" minlength="6">
                                </div>

                                {{-- Confirm Password --}}
                                <div class="col-md-8">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>

                                {{-- Status --}}
                                <div class="col-md-8">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status', $customer->status) == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status', $customer->status) == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="bx bx-save me-1"></i> Update Customer
                                    </button>
                                    <a href="{{ route('backend.customers.delete', $customer->id) }}" onclick="return confirm('Permanently delete this customer?')" class="btn btn-sm btn-outline-danger ms-2">
                                        <i class="bx bxs-trash me-1"></i> Delete
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#photoInput').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
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
