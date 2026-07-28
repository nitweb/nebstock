{{-- resources/views/frontend/customer/auth/reset.blade.php --}}
@extends('frontend.dashboard')

@section('frontend_title', 'Reset Password')

@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Reset Password</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Reset Password</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="auth__section">
        <div class="auth__container">

            <!-- Left: Illustration Side (same as login) -->
            <div class="auth__left">
                <div class="auth__left--inner">
                    <div class="auth__brand">
                        <img src="{{ asset('frontend/assets/img/favicon.png') }}" alt="Site Logo" style="width: 10%;">
                        <span>Welcome Back!</span>
                    </div>
                    <h2 class="auth__left--title">Reset your password</h2>
                    <p class="auth__left--desc">Enter a new password to regain access.</p>
                </div>
            </div>

            <!-- Right: Reset form -->
            <div class="auth__right">
                <div class="auth__form--wrap">

                    <div class="auth__form--header">
                        <h3>Reset Password</h3>
                        <p>Fill in the fields below to set a new password.</p>
                    </div>

                    {{-- Success / Error --}}
                    @if (session('status'))
                        <div class="auth__alert success">{{ session('status') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="auth__alert error">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST" class="auth__form">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="auth__field">
                            <label class="auth__label">Email Address</label>
                            <div class="auth__input--wrap">
                                <span class="auth__input--icon">@</span>
                                <input type="email" name="email" value="{{ old('email', $email) }}" readonly required class="auth__input @error('email') is-invalid @enderror" placeholder="you@example.com">
                            </div>
                            @error('email')
                                <span class="auth__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="auth__field">
                            <label class="auth__label">New Password</label>
                            <div class="auth__input--wrap">
                                <span class="auth__input--icon">🔒</span>
                                <input type="password" name="password" required class="auth__input @error('password') is-invalid @enderror" placeholder="New password">
                            </div>
                            @error('password')
                                <span class="auth__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="auth__field">
                            <label class="auth__label">Confirm Password</label>
                            <div class="auth__input--wrap">
                                <span class="auth__input--icon">🔒</span>
                                <input type="password" name="password_confirmation" required class="auth__input" placeholder="Confirm password">
                            </div>
                        </div>

                        <button type="submit" class="auth__btn">
                            Reset Password
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="margin-top: -6px;">
                                <path d="M5 12h14M12 5l7 7-7 7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </form>

                    <div class="auth__bottom--link">
                        Remembered your password? <a href="{{ route('customer.login') }}">Login</a>
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
