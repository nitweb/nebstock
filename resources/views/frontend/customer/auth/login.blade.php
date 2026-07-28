@extends('frontend.dashboard')
@section('frontend_title', 'Login')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Login</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Login</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="auth__section">
        <div class="auth__container">

            <!-- Left: Illustration Side -->
            <div class="auth__left">
                <div class="auth__left--inner">
                    <div class="auth__brand">
                        <img src="{{ asset('frontend/assets/img/favicon.png') }}" alt="Site Logo" style="width: 10%;">
                        <span>Welcome Back!</span>
                    </div>
                    <h2 class="auth__left--title">Sign in to your account</h2>
                    <p class="auth__left--desc">Access your orders, wishlist, and personalized shopping experience.</p>

                    <div class="auth__features">
                        <div class="auth__feature--item">
                            <div class="auth__feature--icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#B8860B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span>Track your orders in real-time</span>
                        </div>
                        <div class="auth__feature--item">
                            <div class="auth__feature--icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#B8860B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span>Save items to your wishlist</span>
                        </div>
                        <div class="auth__feature--item">
                            <div class="auth__feature--icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#B8860B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span>Faster checkout every time</span>
                        </div>
                        <div class="auth__feature--item">
                            <div class="auth__feature--icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#B8860B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span>Exclusive deals & offers</span>
                        </div>
                    </div>

                    <div class="auth__left--footer">
                        Don't have an account?
                        <a href="{{ route('customer.register') }}">Create one free →</a>
                    </div>
                </div>
            </div>

            <!-- Right: Form Side -->
            <div class="auth__right">
                <div class="auth__form--wrap">

                    <div class="auth__form--header">
                        <h3>Sign In</h3>
                        <p>Enter your credentials to continue</p>
                    </div>

                    {{-- Success / Error --}}
                    @if (session('success'))
                        <div class="auth__alert success">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#15803d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="auth__alert error">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="#b91c1c" stroke-width="2" />
                                <path d="M12 8v4M12 16h.01" stroke="#b91c1c" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('customer.login.submit') }}" method="POST" class="auth__form">
                        @csrf

                        <div class="auth__field">
                            <label class="auth__label">Email Address</label>
                            <div class="auth__input--wrap">
                                <span class="auth__input--icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                        <polyline points="22,6 12,13 2,6" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <input type="email" name="email" class="auth__input @error('email') is-invalid @enderror" placeholder="you@example.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <span class="auth__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="auth__field">
                            <label class="auth__label">Password</label>
                            <div class="auth__input--wrap">
                                <span class="auth__input--icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="11" width="18" height="11" rx="2" stroke="#aaa" stroke-width="1.8" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" />
                                    </svg>
                                </span>
                                <input type="password" name="password" id="loginPassword" class="auth__input" placeholder="Enter your password" required>
                                <button type="button" class="auth__eye--btn" onclick="togglePass('loginPassword', this)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="#aaa" stroke-width="1.8" />
                                        <circle cx="12" cy="12" r="3" stroke="#aaa" stroke-width="1.8" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="auth__row">
                            <label class="auth__remember">
                                <input type="checkbox" name="remember">
                                <span class="auth__checkbox"></span>
                                Remember me
                            </label>
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        </div>

                        <button type="submit" class="auth__btn">
                            Sign In
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="margin-top: -6px;">
                                <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                    </form>

                    <div class="auth__bottom--link">
                        New here?
                        <a href="{{ route('customer.register') }}">Create a free account</a>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
            btn.style.opacity = input.type === 'text' ? '1' : '0.5';
        }
    </script>

@endsection
