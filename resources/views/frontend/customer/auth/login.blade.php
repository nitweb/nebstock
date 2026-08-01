@extends('frontend.dashboard')
@section('frontend_title', 'Login')
@section('frontend_contents')

    <section class="account d-flex">
        <img src="{{ asset('frontend/assets/images/thumbs/account-img.png') }}" alt="" class="account__img">
        <div class="account__left d-md-flex d-none flx-align section-bg position-relative z-index-1 overflow-hidden">
            <img src="{{ asset('frontend/assets/images/shapes/pattern-curve-seven.png') }}" alt="" class="position-absolute end-0 top-0 z-index--1 h-100">
            <div class="account-thumb">
                <img src="{{ asset('frontend/assets/images/thumbs/banner-img.png') }}" alt="">
            </div>
        </div>
        <div class="account__right padding-y-120 flx-align">

            <div class="account-content">
                <a href="{{ route('index') }}" class="logo mb-64">
                    <img src="{{ asset(GlobalSiteSettings()->site_header_logo ?? 'frontend/assets/images/logo/logo.png') }}" alt="">
                </a>
                <h4 class="account-content__title mb-48 text-capitalize">Welcome Back!</h4>

                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                @endif

                <form action="{{ route('customer.login.submit') }}" method="POST">
                    @csrf
                    <div class="row gy-4">
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
                            <button type="submit" class="btn btn-main btn-lg w-100 pill"> Sign In</button>
                        </div>
                        <div class="col-sm-12 mb-0">
                            <div class="have-account">
                                <p class="text font-14">New to the market? <a class="link text-main text-decoration-underline fw-500" href="{{ route('customer.register') }}">sign up</a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
