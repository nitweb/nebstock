@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">About Company Edit</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.about_company.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> About Company
                            </a>
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

                            <form class="row g-3" action="{{ route('backend.about_company.update') }}" method="post" enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" name="id" value="{{ $about_info->id }}">

                                <div class="col-md-8">
                                    <label for="example-text-input" class="form-label">Image</label>
                                    <input type="file" class="form-control" name="about_image" id="image">
                                    <img id="showImage" src="{{ !empty($about_info->about_image) ? url('upload/about_image/' . $about_info->about_image) : url('upload/no_image.jpg') }}" alt="About Company Cover Image" class="p-1 bg-primary mt-3" style="width: 110px; height: 110px; object-fit: cover; border-radius: 8px;">
                                </div>

                                <div class="col-8">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="about_description" id="summernote" required>{!! $about_info->about_description !!}</textarea>
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
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
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
