@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Mission/Vision/Values Edit</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.mission_vision.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Mission/Vision/Values List
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

                            <form class="row g-3" action="{{ route('backend.mission_vision.update') }}" method="post">

                                @csrf

                                <input type="hidden" name="id" value="{{ $mission_vision_info->id }}">

                                <div class="col-md-8">
                                    <label for="text" class="form-label">FontAwesome Icon <span>[<a href="{{ route('backend.site_settings.font_awesome') }}">Click Here For Icons</a>]</span></label>
                                    <input type="text" class="form-control" id="text" name="mission_vision_icon" value="{{ $mission_vision_info->mission_vision_icon }}">
                                </div>

                                <div class="col-md-8">
                                    <label for="text" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="text" name="mission_vision_title" value="{{ $mission_vision_info->mission_vision_title }}">
                                </div>

                                <div class="col-md-8">
                                    <label for="textarea" class="form-label">Description</label>
                                    <textarea class="form-control" id="textarea" name="mission_vision_description" rows="4" required>{{ $mission_vision_info->mission_vision_description }}</textarea>
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
