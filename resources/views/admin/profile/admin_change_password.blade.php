@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Admin Change Password</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                                <li class="breadcrumb-item active">Admin Change Password</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="col-xl-9 col-lg-8">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-sm order-2 order-sm-1">
                                    <div class="d-flex align-items-start mt-3 mt-sm-0">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-xl me-3">
                                                <img src="{{ !empty($profile_data->photo) ? url('upload/admin_images/' . $profile_data->photo) : url('upload/no_image.jpg') }}" alt="" class="img-fluid rounded-circle d-block">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div>
                                                <h5 class="font-size-16 mb-1">{{ $profile_data->name }}</h5>
                                                <p class="text-muted font-size-13">{{ $profile_data->email }}</p>
                                                <div class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                                    <div><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{ $profile_data->phone }}</div>
                                                    <div><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{ $profile_data->address }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card">

                        <div class="card-body p-4">

                            <form action="{{ route('admin.password.update') }}" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="row">

                                    <div class="col-lg-6">

                                        <div>

                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Old Password</label>
                                                    </div>
                                                </div>
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" aria-label="Password" aria-describedby="password-addon-class">
                                                    <button class="btn btn-light shadow-none ms-0 password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                                @error('old_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">New Password</label>
                                                    </div>
                                                </div>
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" aria-label="Password" aria-describedby="password-addon">
                                                    <button class="btn btn-light shadow-none ms-0 password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                                @error('new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Confirm New Password</label>
                                                    </div>
                                                </div>
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" name="new_password_confirmation" class="form-control" aria-label="Password" aria-describedby="password-addon">
                                                    <button class="btn btn-light shadow-none ms-0 password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                            </div>


                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
