@extends('frontend.customer.dashboard')
@section('customer_title', 'Customer Profile')
@section('customer_contents')

    @if(session('message'))
        <div class="alert alert-{{ session('alert-type') === 'success' ? 'success' : 'danger' }} mb-4">{{ session('message') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="dashboard-body__content profile-content-wrapper z-index-1 position-relative">
        <!-- Profile Content Start -->
        <div class="profile">
            <div class="row gy-4">

                <div class="col-xxl-4 col-xl-4">
                    <div class="profile-info">
                        <div class="profile-info__inner mb-40 text-center">

                            <div class="avatar-upload mb-24">
                                {{-- <div class="avatar-edit">
                                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg">
                                    <label for="imageUpload">
                                        <img src="{{ asset('frontend/assets/images/icons/camera.svg') }}" alt="">
                                    </label>
                                </div> --}}
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url('{{ $customer->photo ? asset('upload/customer_images/' . $customer->photo) : asset('frontend/assets/images/thumbs/user-profile.png') }}');">
                                    </div>
                                </div>
                            </div>

                            <h5 class="profile-info__name mb-1">{{ $customer->name }}</h5>
                            <span class="profile-info__designation font-14 text-capitalize">{{ $customer->payment_status }} Member</span>
                        </div>

                        <ul class="profile-info-list">
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ asset('frontend/assets/images/icons/profile-info-icon2.svg') }}" alt="" class="icon">
                                    <span class="text text-heading fw-500">Email</span>
                                </span>
                                <span class="profile-info-list__info">{{ $customer->email }}</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ asset('frontend/assets/images/icons/profile-info-icon3.svg') }}" alt="" class="icon">
                                    <span class="text text-heading fw-500">Phone</span>
                                </span>
                                <span class="profile-info-list__info">{{ $customer->phone ?: '—' }}</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ asset('frontend/assets/images/icons/profile-info-icon4.svg') }}" alt="" class="icon">
                                    <span class="text text-heading fw-500">Address</span>
                                </span>
                                <span class="profile-info-list__info">{{ $customer->address ?: '—' }}</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ asset('frontend/assets/images/icons/profile-info-icon6.svg') }}" alt="" class="icon">
                                    <span class="text text-heading fw-500">Member Since</span>
                                </span>
                                <span class="profile-info-list__info">{{ $customer->created_at->format('M, d, Y') }}</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ asset('frontend/assets/images/icons/profile-info-icon7.svg') }}" alt="" class="icon">
                                    <span class="text text-heading fw-500">Downloaded</span>
                                </span>
                                <span class="profile-info-list__info">{{ $totalDownloads }} items</span>
                            </li>
                        </ul>

                    </div>
                </div>

                <div class="col-xxl-8 col-xl-8">
                    <div class="dashboard-card">
                        <div class="dashboard-card__header pb-0">
                            <ul class="nav tab-bordered nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link font-18 font-heading active" id="pills-personalInfo-tab" data-bs-toggle="pill" data-bs-target="#pills-personalInfo" type="button" role="tab" aria-controls="pills-personalInfo" aria-selected="true">Personal Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link font-18 font-heading" id="pills-changePassword-tab" data-bs-toggle="pill" data-bs-target="#pills-changePassword" type="button" role="tab" aria-controls="pills-changePassword" aria-selected="false">Change Password</button>
                                </li>
                            </ul>
                        </div>

                        <div class="profile-info-content">

                            <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="pills-personalInfo" role="tabpanel" aria-labelledby="pills-personalInfo-tab" tabindex="0">
                                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                        <div class="row gy-4">
                                            <div class="col-sm-6 col-xs-6">
                                                <label for="fName" class="form-label mb-2 font-18 font-heading fw-600">Full Name</label>
                                                <input type="text" name="name" class="common-input border" id="fName" value="{{ old('name', $customer->name) }}" placeholder="Full Name">
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <label for="phonee" class="form-label mb-2 font-18 font-heading fw-600">Phone Number</label>
                                                <input type="tel" name="phone" class="common-input border" id="phonee" value="{{ old('phone', $customer->phone) }}" placeholder="Phone Number">
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <label for="emailAdddd" class="form-label mb-2 font-18 font-heading fw-600">Email Address</label>
                                                <input type="email" name="email" class="common-input border" id="emailAdddd" value="{{ old('email', $customer->email) }}" placeholder="Email Address">
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <label for="addresss" class="form-label mb-2 font-18 font-heading fw-600">Address</label>
                                                <input type="text" name="address" class="common-input border" id="addresss" value="{{ old('address', $customer->address) }}" placeholder="Address">
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <label for="photoo" class="form-label mb-2 font-18 font-heading fw-600">Profile Photo</label>
                                                <input type="file" name="photo" class="common-input border" id="photoo" accept=".png,.jpg,.jpeg">
                                            </div>

                                            <div class="col-sm-12 text-end">
                                                <button type="submit" class="btn btn-main btn-lg pill mt-4"> Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="pills-changePassword" role="tabpanel" aria-labelledby="pills-changePassword-tab" tabindex="0">
                                    <form action="{{ route('customer.password.change') }}" method="POST" autocomplete="off">
                                        @csrf
                                        <div class="row gy-4">

                                            <div class="col-12">
                                                <label for="current-password" class="form-label mb-2 font-18 font-heading fw-600">Current Password</label>
                                                <div class="position-relative">
                                                    <input type="password" name="old_password" class="common-input common-input--withIcon common-input--withLeftIcon " id="current-password" placeholder="************">
                                                    <span class="input-icon input-icon--left"><img src="{{ asset('frontend/assets/images/icons/key-icon.svg') }}" alt=""></span>
                                                    <span class="input-icon password-show-hide fas fa-eye la-eye-slash toggle-password-two" id="#current-password"></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-xs-6">
                                                <label for="new-password" class="form-label mb-2 font-18 font-heading fw-600">New Password</label>
                                                <div class="position-relative">
                                                    <input type="password" name="new_password" class="common-input common-input--withIcon common-input--withLeftIcon " id="new-password" placeholder="************">
                                                    <span class="input-icon input-icon--left"><img src="{{ asset('frontend/assets/images/icons/lock-two.svg') }}" alt=""></span>
                                                    <span class="input-icon password-show-hide fas fa-eye la-eye-slash toggle-password-two" id="#new-password"></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-xs-6">
                                                <label for="confirm-password" class="form-label mb-2 font-18 font-heading fw-600">Confirm Password</label>
                                                <div class="position-relative">
                                                    <input type="password" name="new_password_confirmation" class="common-input common-input--withIcon common-input--withLeftIcon " id="confirm-password" placeholder="************">
                                                    <span class="input-icon input-icon--left"><img src="{{ asset('frontend/assets/images/icons/lock-two.svg') }}" alt=""></span>
                                                    <span class="input-icon password-show-hide fas fa-eye la-eye-slash toggle-password-two" id="#confirm-password"></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 text-end">
                                                <button type="submit" class="btn btn-main btn-lg pill mt-4"> Update Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- Profile Content End -->

    </div>

@endsection
