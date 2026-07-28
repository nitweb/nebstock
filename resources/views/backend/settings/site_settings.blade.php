@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Site Settings Edit</h4>
                        <div class="page-title-right">
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
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

                            <form class="row g-3" action="{{ route('backend.site_settings.update') }}" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="col-md-6">
                                    <label for="site_header_logo" class="form-label">Site Header Logo</label>
                                    <input type="file" class="form-control" name="site_header_logo" id="site_header_logo">
                                    <img id="showHeaderLogo" src="{{ !empty($site_settings_info->site_header_logo) ? url($site_settings_info->site_header_logo) : url('upload/no_image.jpg') }}" alt="Site Header Logo" class="p-1 bg-primary mt-3" style="width: 40%; object-fit: cover; border-radius: 8px;">
                                </div>

                                <div class="col-md-6">
                                    <label for="site_footer_logo" class="form-label">Site Footer Logo</label>
                                    <input type="file" class="form-control" name="site_footer_logo" id="site_footer_logo">
                                    <img id="showFooterLogo" src="{{ !empty($site_settings_info->site_footer_logo) ? url($site_settings_info->site_footer_logo) : url('upload/no_image.jpg') }}" alt="Site Footer Logo" class="p-1 bg-primary mt-3" style="width: 40%; object-fit: cover; border-radius: 8px;">
                                </div>

                                <div class="col-md-6">
                                    <label for="site_email" class="form-label">Site Mail</label>
                                    <input type="email" class="form-control" id="site_email" name="site_email" value="{{ $site_settings_info->site_email }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="site_email_alt" class="form-label">Site Mail Alt</label>
                                    <input type="email" class="form-control" id="site_email_alt" name="site_email_alt" value="{{ $site_settings_info->site_email_alt }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="site_phone" class="form-label">Site Phone</label>
                                    <input type="text" class="form-control" id="site_phone" name="site_phone" value="{{ $site_settings_info->site_phone }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="site_phone_alt" class="form-label">Site Phone Alt</label>
                                    <input type="text" class="form-control" id="site_phone_alt" name="site_phone_alt" value="{{ $site_settings_info->site_phone_alt }}">
                                </div>

                                <div class="col-md-12">
                                    <label for="site_address" class="form-label">Site Address</label>
                                    <input type="text" class="form-control" id="site_address" name="site_address" value="{{ $site_settings_info->site_address }}" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="site_description" class="form-label">Site Description</label>
                                    <textarea class="form-control" id="site_description" name="site_description" rows="4" required>{{ $site_settings_info->site_description }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="site_copyright" class="form-label">Site Copyright</label>
                                    <input type="text" class="form-control" id="site_copyright" name="site_copyright" value="{{ $site_settings_info->site_copyright }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="site_google_map" class="form-label">Site Google Map</label>
                                    <input type="text" class="form-control" id="site_google_map" name="site_google_map" value="{{ $site_settings_info->site_google_map }}" required>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#site_header_logo').change(function(e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#showHeaderLogo').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });

            $('#site_footer_logo').change(function(e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#showFooterLogo').attr('src', e.target.result);
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
