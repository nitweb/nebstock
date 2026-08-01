@extends('frontend.dashboard')
@section('frontend_title', 'Create Account')
@section('frontend_contents')

    <section class="account d-flex">
        <img src="{{ asset('frontend/assets/images/thumbs/account-img.png') }}" alt="" class="account__img">
        <div class="account__left d-md-flex d-none flx-align section-bg position-relative z-index-1 overflow-hidden">
            <img src="{{ asset('frontend/assets/images/shapes/pattern-curve-seven.png') }}" alt="" class="position-absolute end-0 top-0 z-index--1 h-100">
            <div class="account-thumb">
                <img src="{{ asset('frontend/assets/images/thumbs/banner-img.png') }}" alt="">
                <div class="statistics animation bg-main text-center">
                    <h5 class="statistics__amount text-white">{{ $site_settings_info->registration_fee ?? 0 }}৳</h5>
                    <span class="statistics__text text-white font-14">One-time Fee</span>
                </div>
            </div>
        </div>
        <div class="account__right padding-t-120 flx-align">

            <div class="account-content">
                <a href="{{ route('index') }}" class="logo mb-64">
                    <img src="{{ asset($site_settings_info->site_header_logo ?? 'frontend/assets/images/logo/logo.png') }}" alt="">
                </a>
                <h4 class="account-content__title mb-3 text-capitalize">Create A Free Account</h4>

                @if($site_settings_info && $site_settings_info->registration_fee > 0)
                    <div class="alert alert-info mb-4">
                        <strong>One-time Registration Fee: {{ number_format($site_settings_info->registration_fee, 2) }}৳</strong><br>
                        Send Money via bKash to <strong>{{ $site_settings_info->bkash_merchant_number ?? 'N/A' }}</strong>,
                        then enter your bKash number and Transaction ID below to unlock all downloads instantly.
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
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

                <form action="{{ route('customer.register.submit') }}" method="POST">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-12">
                            <label for="name" class="form-label mb-2 font-18 font-heading fw-600">Full Name</label>
                            <div class="position-relative">
                                <input type="text" name="name" class="common-input common-input--bg common-input--withIcon" id="name" placeholder="Your full name" value="{{ old('name') }}" required>
                                <span class="input-icon"><img src="{{ asset('frontend/assets/images/icons/user-icon.svg') }}" alt=""></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label mb-2 font-18 font-heading fw-600">Email</label>
                            <div class="position-relative">
                                <input type="email" name="email" class="common-input common-input--bg common-input--withIcon" id="email" placeholder="infoname@mail.com" value="{{ old('email') }}" required>
                                <span class="input-icon"><img src="{{ asset('frontend/assets/images/icons/envelope-icon.svg') }}" alt=""></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="your-password" class="form-label mb-2 font-18 font-heading fw-600">Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" class="common-input common-input--bg common-input--withIcon" id="your-password" placeholder="6+ characters" required>
                                <span class="input-icon toggle-password cursor-pointer"><img src="{{ asset('frontend/assets/images/icons/lock-icon.svg') }}" alt=""></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="password_confirmation" class="form-label mb-2 font-18 font-heading fw-600">Confirm Password</label>
                            <div class="position-relative">
                                <input type="password" name="password_confirmation" class="common-input common-input--bg common-input--withIcon" id="password_confirmation" placeholder="Re-enter password" required>
                                <span class="input-icon toggle-password cursor-pointer"><img src="{{ asset('frontend/assets/images/icons/lock-icon.svg') }}" alt=""></span>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        <div class="col-12">
                            <label for="bkash_number" class="form-label mb-2 font-18 font-heading fw-600">Your bKash Number</label>
                            <div class="position-relative">
                                <input type="text" name="bkash_number" class="common-input common-input--bg common-input--withIcon" id="bkash_number" placeholder="01XXXXXXXXX" value="{{ old('bkash_number') }}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="bkash_transaction_id" class="form-label mb-2 font-18 font-heading fw-600">bKash Transaction ID</label>
                            <div class="position-relative">
                                <input type="text" name="bkash_transaction_id" class="common-input common-input--bg common-input--withIcon" id="bkash_transaction_id" placeholder="e.g. 9J7Z3XY1AB" value="{{ old('bkash_transaction_id') }}" required style="text-transform:uppercase">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="common-check my-2">
                                <input class="form-check-input" type="checkbox" name="checkbox" id="agree" required>
                                <label class="form-check-label mb-0 fw-400 font-16 text-body" for="agree">I agree to the terms & conditions</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-main btn-lg w-100 pill"> Create An Account</button>
                        </div>
                        <div class="col-sm-12 mb-0">
                            <div class="have-account">
                                <p class="text font-14">Already a member? <a class="link text-main text-decoration-underline fw-500" href="{{ route('customer.login') }}">Login</a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
