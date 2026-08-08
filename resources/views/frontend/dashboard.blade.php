<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>@yield('frontend_title') | nebstock</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/logo/favicon.png') }}">

    <!-- Open Graph / Social Share -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="nebstock">
    <meta property="og:title" content="@yield('frontend_title') | nebstock">
    <meta property="og:description" content="{{ GlobalSiteSettings()->site_description ?? '' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('frontend/assets/images/logo/og.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('frontend_title') | nebstock">
    <meta name="twitter:description" content="{{ GlobalSiteSettings()->site_description ?? '' }}">
    <meta name="twitter:image" content="{{ asset('frontend/assets/images/logo/og.png') }}">

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
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}?v={{ filemtime(public_path('frontend/assets/css/main.css')) }}">

<link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}?v={{ filemtime(public_path('frontend/assets/css/custom.css')) }}">

</head>

<body>

    <!--==================== Preloader Start ====================-->
    {{-- @include('frontend.layouts.preloader') --}}
    <!--==================== Preloader End ====================-->

    <!--==================== Overlay Start ====================-->
    <div class="overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- ==================== Scroll to Top End Here ==================== -->

    <!-- ==================== Mobile Menu Start Here ==================== -->
    @include('frontend.layouts.mobile_menu')
    <!-- ==================== Mobile Menu End Here ==================== -->

    <main class="change-gradient">

        <!-- ============================ Sale Offer Start =========================== -->
        @include('frontend.layouts.top_bar')
        <!-- ============================ Sale Offer End =========================== -->

        <!-- ==================== Header Start Here ==================== -->
        @include('frontend.layouts.header')
        <!-- ==================== Header End Here ==================== -->

        @yield('frontend_contents')

        <!-- ==================== Footer Start Here ==================== -->
        @include('frontend.layouts.footer')
        <!-- ==================== Footer End Here ==================== -->

    </main>

    <!-- ==================== WhatsApp Floating Icon Start ==================== -->
    <a href="https://wa.me/8801628533023" target="_blank" class="whatsapp-float" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <!-- ==================== WhatsApp Floating Icon End ==================== -->

    <!-- Jquery js -->
    <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="{{ asset('frontend/assets/js/boostrap.bundle.min.js') }}"></script>
    <!-- CountDown -->
    <script src="{{ asset('frontend/assets/js/countdown.js') }}"></script>
    <!-- counter up -->
    <script src="{{ asset('frontend/assets/js/counterup.min.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
    <!-- magnific popup -->
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.js') }}"></script>
    <!-- apex chart -->
    <script src="{{ asset('frontend/assets/js/apexchart.js') }}"></script>
    <!-- marquee -->
    <script src="{{ asset('frontend/assets/js/marquee.min.js') }}"></script>

    <!-- main js -->
    <script src="{{ asset('frontend/assets/js/main.js') }}?v={{ filemtime(public_path('frontend/assets/js/main.js')) }}"></script>

    @stack('scripts')

</body>

</html>
