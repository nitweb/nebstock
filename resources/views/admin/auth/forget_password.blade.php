<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Reset Password</title>

    {{-- Favicon Icon --}}
   <link rel="icon" type="image/png" href="{{ asset('frontend/assets/images/favicons/favicon.png') }}" />
    {{-- Bootstrap CSS --}}
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    {{-- Icons CSS --}}
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- App CSS --}}
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <style>
        .custom_site_btn {
            color: #fff;
            background-color: #e74399;
            border-color: #e74399;
        }

        .custom_site_btn:hover {
            color: #fff;
            background-color: #6cb446;
            border-color: #6cb446;
        }

        .custom_site_text{
            color: #e74399 !important;
        }

        .custom_site_text:hover{
            color: #6cb446 !important;
        }
    </style>

</head>

<body>

    <div class="auth-page">

        <div class="container-fluid p-0">

            <div class="d-flex align-items-center justify-content-center min-vh-100" style="position: relative;">
                <div class="bg-overlay bg-primary" style="opacity: 0.9; position: absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                <ul class="bg-bubbles" style="z-index:2; position:absolute; width:100%; height:100%; left:0; top:0; pointer-events:none;">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
                <div class="auth-full-page-content d-flex p-4" style="z-index:3; min-width:350px; max-width:450px; width:100%;">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="auth-content my-auto">
                                <div class="card shadow">
                                    <div class="card-body mb-4">

                                        <div class="m-3 m-md-4 text-center">
                                            <a href="{{ route('index') }}" class="d-block auth-logo" target="_blank">
                                                <img src="{{ asset(GlobalSiteSettings()->site_footer_logo) }}" alt="" class="img-fluid" width="180px">
                                            </a>
                                        </div>

                                        <div class="text-center">
                                            <h5 class="mb-0">Reset Password</h5>
                                            <p class="text-muted mt-2">Enter your Email and instructions will be sent to you!</p>
                                        </div>

                                        {{-- #################### Start: Error/Success Notification #################### --}}
                                        @if ($errors->any())
                                            <div class="alert alert-danger text-center my-4" role="alert">
                                                <ul class="text-danger mt-3">
                                                    @foreach ($errors->all() as $error)
                                                        <li style="text-align: left;">{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @if (Session::has('error'))
                                            <div class="alert alert-danger text-center my-4" role="alert">
                                                <ul class="text-danger mt-3">
                                                    <li style="text-align: left;">{{ Session::get('error') }}</li>
                                                </ul>
                                            </div>
                                        @endif

                                        @if (Session::has('success'))
                                            <div class="alert alert-success text-center my-4" role="alert">
                                                <ul class="text-success mt-3">
                                                    <li style="text-align: left;">{{ Session::get('success') }}</li>
                                                </ul>
                                            </div>
                                        @endif
                                        {{-- #################### End: Error/Success Notification #################### --}}

                                        <form class="mt-4 pt-2" action="{{ route('admin.forget.password.submit') }}" method="post">

                                            @csrf

                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
                                            </div>

                                            <div class="mb-3">
                                                <button class="btn btn-primary w-100 waves-effect waves-light custom_site_btn" type="submit">Reset</button>
                                            </div>

                                        </form>

                                        <div class="mt-4 text-center">
                                            <p class="text-muted mb-0">Remember It ? <a href="{{ route('admin.login') }}" class="text-primary fw-semibold custom_site_text"> Sign In </a></p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


    {{-- jQuery --}}
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    {{-- Bootstrap JS --}}
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- Metis Menu JS --}}
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    {{-- Simple Bar JS --}}
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    {{-- Node Waves JS --}}
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    {{-- Feather Icons JS --}}
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>
    {{-- Pace JS --}}
    <script src="{{ asset('backend/assets/libs/pace-js/pace.min.js') }}"></script>
    {{-- Password Adoon Init JS --}}
    <script src="{{ asset('backend/assets/js/pages/pass-addon.init.js') }}"></script>

</body>

</html>
