<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>Customer Login | Nebedge</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/logo/favicon.png') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome-all.min.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.css') }}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
    <!-- line awesome -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/line-awesome.min.css') }}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">
    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">

</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="loader-mask">
        <div class="loader">
            <div></div>
            <div></div>
        </div>
    </div>
    <!--==================== Preloader End ====================-->

    <div class="overlay"></div>
    <div class="side-overlay"></div>

    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    @include('frontend.layouts.mobile_menu')

    <!-- ================================== Account Page Start =========================== -->
    <section class="account d-flex">
        <img src="{{ asset('frontend/assets/images/thumbs/account-img.png') }}" alt="" class="account__img">
        <div class="account__left d-md-flex d-none flx-align section-bg position-relative z-index-1 overflow-hidden">
            <img src="{{ asset('frontend/assets/images/shapes/pattern-curve-seven.png') }}" alt="" class="position-absolute end-0 top-0 z-index--1 h-100">
            <div class="account-thumb">
                <img src="{{ asset('frontend/assets/images/thumbs/banner-img.png') }}" alt="">
                <div class="statistics animation bg-main text-center">
                    <h5 class="statistics__amount text-white">50k</h5>
                    <span class="statistics__text text-white font-14">Customers</span>
                </div>
            </div>
        </div>
        <div class="account__right padding-y-120 flx-align">

            <div class="dark-light-mode">
                <div class="theme-switch-wrapper position-relative">
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" class="d-none" id="checkbox">
                        <span class="slider text-black header-right__button white-version">
                            <img src="{{ asset('frontend/assets/images/icons/sun.svg') }}" alt="">
                        </span>
                        <span class="slider text-black header-right__button dark-version">
                            <img src="{{ asset('frontend/assets/images/icons/moon.svg') }}" alt="">
                        </span>
                    </label>
                </div>
            </div>

            <div class="account-content">
                <a href="{{ route('index') }}" class="logo mb-64">
                    <img src="{{ asset(GlobalSiteSettings()->site_header_logo ?? 'frontend/assets/images/logo/logo.png') }}" alt="" class="white-version">
                    <img src="{{ asset('frontend/assets/images/logo/white-logo-two.png') }}" alt="" class="dark-version">
                </a>
                <h4 class="account-content__title mb-48 text-capitalize">Welcome Back!</h4>

                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
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
                                <span class="input-icon toggle-password cursor-pointer" id="#your-password"><img src="{{ asset('frontend/assets/images/icons/lock-icon.svg') }}" alt=""></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="flx-between gap-1">
                                <div class="common-check my-2">
                                    <input class="form-check-input" type="checkbox" name="keepMe" id="keepMe">
                                    <label class="form-check-label mb-0 fw-400 font-14 text-body" for="keepMe">Keep me signed in</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-password text-decoration-underline text-main text-poppins font-14">Forgot password?</a>
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
    <!-- ================================== Account Page End =========================== -->

    <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/boostrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/countdown.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/counterup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/apexchart.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/marquee.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

    @stack('scripts')

</body>

</html>
