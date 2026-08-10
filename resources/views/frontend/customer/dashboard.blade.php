<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>@yield('customer_title') | Nebstock</title>

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

    <section class="dashboard">
        <div class="dashboard__inner d-flex">

            <!-- ===================== Dashboard Sidebar Start ======================= -->
            @include('frontend.customer.layouts.sidebar')
            <!-- ===================== Dashboard Sidebar End ======================= -->

            <div class="dashboard-body">

                <!-- Dashboard Nav Start -->
                @include('frontend.customer.layouts.header')
                <!-- Dashboard Nav End -->


                <div class="dashboard-body__content">

                    @php $__payCustomer = Auth::guard('user')->user(); @endphp
                    @if($__payCustomer && $__payCustomer->payment_status !== 'approved' && !request()->routeIs('customer.payment'))
                        <div class="alert alert-warning d-flex justify-content-between align-items-center flex-wrap gap-2 mb-24">
                            <span>Your one-time payment is pending — downloads are locked until it's verified.</span>
                            <a href="{{ route('customer.payment') }}" class="btn btn-main btn-sm pill">Complete Payment</a>
                        </div>
                    @endif

                    @yield('customer_contents')

                </div>

                <!-- ====================== Dashboard Footer Start ======================== -->
                @include('frontend.customer.layouts.footer')
                <!-- ====================== Dashboard Footer End ======================== -->
            </div>
        </div>
    </section>

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
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

    @if(session('limit_reached'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Daily Limit Reached',
                        text: @json(session('error') ?? 'You have reached your daily download limit. Please wait for the next day.'),
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert(@json(session('error') ?? 'You have reached your daily download limit. Please wait for the next day.'));
                }
            });
        </script>
    @endif

    @if(session('payment_required'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Payment Required',
                        text: @json(session('error') ?? 'Please complete your one-time payment to unlock downloads.'),
                        confirmButtonText: 'Pay Now'
                    });
                } else {
                    alert(@json(session('error') ?? 'Please complete your one-time payment to unlock downloads.'));
                }
            });
        </script>
    @endif

    <script>
        document.addEventListener('submit', function (e) {
            if (e.target.matches('form[action*="/download/"]')) {
                var btn = e.target.querySelector('button[type="submit"]');
                if (btn) {
                    if (btn.disabled) { e.preventDefault(); return; }
                    btn.disabled = true;
                    setTimeout(function () { btn.disabled = false; }, 4000);
                }
            }
        });
    </script>

    @stack('scripts')

</body>

</html>