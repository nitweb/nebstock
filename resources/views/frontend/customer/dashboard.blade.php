<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>@yield('customer_title') | Nebstock</title>

    <!-- Favicon -->
    <link rel="shortcut icon"
        href="{{ asset('frontend/assets/images/logo/favicon.png') }}?v={{ filemtime(public_path('frontend/assets/images/logo/favicon.png')) }}">


    <!-- ==================== CSS Start ==================== -->

    <!-- Bootstrap -->
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">

    <!-- Fontawesome -->
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/css/fontawesome-all.min.css') }}">

    <!-- Slick -->
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/css/slick.css') }}">

    <!-- Magnific Popup -->
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/css/magnific-popup.css') }}">

    <!-- Line Awesome -->
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/css/line-awesome.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/css/main.css') }}?v={{ filemtime(public_path('frontend/assets/css/main.css')) }}">

    <!-- Custom CSS -->
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/css/custom.css') }}?v={{ filemtime(public_path('frontend/assets/css/custom.css')) }}">

    <!-- ==================== CSS End ==================== -->

</head>

<body>


    <!--==================== Preloader Start ====================-->
    {{-- @include('frontend.layouts.preloader') --}}
    <!--==================== Preloader End ====================-->


    <!--==================== Overlay Start ====================-->
    <div class="overlay"></div>
    <!--==================== Overlay End ====================-->


    <!--==================== Sidebar Overlay Start ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->


    <!-- ==================== Scroll to Top Start ==================== -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content"
            width="100%"
            height="100%"
            viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0,1,0 0,98 a49,49 0,1,0 0,-98" />
        </svg>
    </div>
    <!-- ==================== Scroll to Top End ==================== -->


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

                    @php
                        $__payCustomer = Auth::guard('user')->user();
                    @endphp

                    @if(
                        $__payCustomer &&
                        $__payCustomer->payment_status !== 'approved' &&
                        !request()->routeIs('customer.payment')
                    )

                        <div
                            class="alert alert-warning d-flex justify-content-between align-items-center flex-wrap gap-2 mb-24">

                            <span>
                                Your one-time payment is pending — downloads are locked until it's verified.
                            </span>

                            <a href="{{ route('customer.payment') }}"
                                class="btn btn-main btn-sm pill">
                                Complete Payment
                            </a>

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


    <!-- ==================== JavaScript Start ==================== -->

    <!-- Jquery JS -->
    <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('frontend/assets/js/boostrap.bundle.min.js') }}"></script>

    <!-- CountDown -->
    <script src="{{ asset('frontend/assets/js/countdown.js') }}"></script>

    <!-- Counter Up -->
    <script src="{{ asset('frontend/assets/js/counterup.min.js') }}"></script>

    <!-- Slick JS -->
    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>

    <!-- Magnific Popup -->
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.js') }}"></script>

    <!-- Apex Chart -->
    <script src="{{ asset('frontend/assets/js/apexchart.js') }}"></script>

    <!-- Marquee -->
    <script src="{{ asset('frontend/assets/js/marquee.min.js') }}"></script>


    <!-- SweetAlert2 (Site-wide toast notifications) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Main JS -->
    <script src="{{ asset('frontend/assets/js/main.js') }}?v={{ filemtime(public_path('frontend/assets/js/main.js')) }}"></script>


    <!-- ==================== Daily Limit Reached ==================== -->
    @if(session('limit_reached'))

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                if (typeof Swal !== 'undefined') {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Daily Limit Reached',
                        text: @json(
                            session('error')
                            ?? 'You have reached your daily download limit. Please wait for the next day.'
                        ),
                        confirmButtonText: 'OK'
                    });

                } else {

                    alert(
                        @json(
                            session('error')
                            ?? 'You have reached your daily download limit. Please wait for the next day.'
                        )
                    );

                }

            });
        </script>

    @endif
    <!-- ==================== Daily Limit Reached End ==================== -->


    <!-- ==================== Payment Required ==================== -->
    @if(session('payment_required'))

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                if (typeof Swal !== 'undefined') {

                    Swal.fire({
                        icon: 'info',
                        title: 'Payment Required',
                        text: @json(
                            session('error')
                            ?? 'Please complete your one-time payment to unlock downloads.'
                        ),
                        confirmButtonText: 'Pay Now'
                    });

                } else {

                    alert(
                        @json(
                            session('error')
                            ?? 'Please complete your one-time payment to unlock downloads.'
                        )
                    );

                }

            });
        </script>

    @endif
    <!-- ==================== Payment Required End ==================== -->


    <!-- ==================== Download Form Protection ==================== -->
    <script>
        document.addEventListener('submit', function (e) {

            if (e.target.matches('form[action*="/download/"]')) {

                var btn = e.target.querySelector('button[type="submit"]');

                if (btn) {

                    if (btn.disabled) {
                        e.preventDefault();
                        return;
                    }

                    btn.disabled = true;

                    setTimeout(function () {
                        btn.disabled = false;
                    }, 4000);

                }

            }

        });
    </script>
    <!-- ==================== Download Form Protection End ==================== -->


    @stack('scripts')

    <!-- ==================== JavaScript End ==================== -->

</body>

</html>