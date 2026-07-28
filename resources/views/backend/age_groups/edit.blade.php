@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Age Group Edit</h4>
                        <div class="page-title-right">
                            <a href="javascript:history.back()" class="btn btn-outline-dark waves-effect waves-light">
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

                            <form class="row g-3" action="{{ route('age_group.update') }}" method="post">

                                @csrf

                                <input type="hidden" name="id" value="{{ $age_group_info->id }}">

                                <div class="col-md-8">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $age_group_info->name }}" required>
                                </div>

                                <div class="col-md-8">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $age_group_info->slug }}" required>
                                </div>


                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @include('admin.layout.custom_scripts')
@endsection
