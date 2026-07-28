@extends('frontend.dashboard')
@section('frontend_title', 'Create Account')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Register</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Register</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="auth__section">
        <div class="auth__container">

            <!-- Left Side -->
            <div class="auth__left reg__left">
                <div class="auth__left--inner">
                    <div class="auth__brand">
                        <img src="{{ asset('frontend/assets/img/favicon.png') }}" alt="Site Logo" style="width: 10%;">
                        <span>Join Us Today!</span>
                    </div>
                    <h2 class="auth__left--title">Create your free account</h2>
                    <p class="auth__left--desc">Join thousands of happy customers and enjoy a seamless shopping experience.</p>

                    <div class="reg__steps">
                        <div class="reg__step">
                            <div class="reg__step--num">1</div>
                            <div>
                                <strong>Fill in your details</strong>
                                <p>Name, email & password</p>
                            </div>
                        </div>
                        <div class="reg__step">
                            <div class="reg__step--num">2</div>
                            <div>
                                <strong>Verify your account</strong>
                                <p>Quick & easy process</p>
                            </div>
                        </div>
                        <div class="reg__step">
                            <div class="reg__step--num">3</div>
                            <div>
                                <strong>Start shopping!</strong>
                                <p>Enjoy exclusive member perks</p>
                            </div>
                        </div>
                    </div>

                    <div class="auth__left--footer">
                        Already have an account?
                        <a href="{{ route('customer.login') }}">Sign in here →</a>
                    </div>
                </div>
            </div>

            <!-- Right: Form -->
            <div class="auth__right">
                <div class="auth__form--wrap">

                    <div class="auth__form--header">
                        <h3>Create Account</h3>
                        <p>It's free and only takes a minute</p>
                    </div>

                    {{-- Alerts --}}
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

                    <form action="{{ route('customer.register.submit') }}" method="POST" class="auth__form">
                        @csrf

                        <div class="auth__field">
                            <label class="auth__label">Full Name</label>
                            <div class="auth__input--wrap">
                                <span class="auth__input--icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" />
                                        <circle cx="12" cy="7" r="4" stroke="#aaa" stroke-width="1.8" />
                                    </svg>
                                </span>
                                <input type="text" name="name" class="auth__input @error('name') is-invalid @enderror" placeholder="Your full name" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                                <span class="auth__error">{{ $message }}</span>
                            @enderror
                        </div>

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
                                <input type="password" name="password" id="regPassword" class="auth__input @error('password') is-invalid @enderror" placeholder="Minimum 6 characters" required>
                                <button type="button" class="auth__eye--btn" onclick="togglePass('regPassword', this)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="#aaa" stroke-width="1.8" />
                                        <circle cx="12" cy="12" r="3" stroke="#aaa" stroke-width="1.8" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="auth__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="auth__field">
                            <label class="auth__label">Confirm Password</label>
                            <div class="auth__input--wrap">
                                <span class="auth__input--icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="11" width="18" height="11" rx="2" stroke="#aaa" stroke-width="1.8" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" />
                                    </svg>
                                </span>
                                <input type="password" name="password_confirmation" id="regConfirm" class="auth__input" placeholder="Re-enter your password" required>
                                <button type="button" class="auth__eye--btn" onclick="togglePass('regConfirm', this)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="#aaa" stroke-width="1.8" />
                                        <circle cx="12" cy="12" r="3" stroke="#aaa" stroke-width="1.8" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Password strength bar -->
                        <div class="auth__strength--wrap" id="strengthWrap" style="display:none;">
                            <div class="auth__strength--bar">
                                <div class="auth__strength--fill" id="strengthFill"></div>
                            </div>
                            <span class="auth__strength--label" id="strengthLabel"></span>
                        </div>

                        <label class="auth__terms">
                            <input type="checkbox" name="terms" required>
                            <span class="auth__checkbox"></span>
                            I agree to the
                            <a href="{{ route('terms.conditions') }}" target="_blank">Terms & Conditions</a>
                            and
                            <a href="{{ route('privacy.policy') }}" target="_blank">Privacy Policy</a>
                        </label>

                        <button type="submit" class="auth__btn" style="margin-top:20px;">
                            Create Account
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="margin-top: -6px;">
                                <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                    </form>

                    <div class="auth__bottom--link">
                        Already have an account?
                        <a href="{{ route('customer.login') }}">Sign in</a>
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

        // Password strength checker
        document.getElementById('regPassword').addEventListener('input', function() {
            const val = this.value;
            const wrap = document.getElementById('strengthWrap');
            const fill = document.getElementById('strengthFill');
            const label = document.getElementById('strengthLabel');

            if (val.length === 0) {
                wrap.style.display = 'none';
                return;
            }
            wrap.style.display = 'flex';

            let score = 0;
            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [{
                    w: '20%',
                    bg: '#ef4444',
                    text: 'Weak'
                },
                {
                    w: '40%',
                    bg: '#f97316',
                    text: 'Fair'
                },
                {
                    w: '60%',
                    bg: '#eab308',
                    text: 'Good'
                },
                {
                    w: '80%',
                    bg: '#22c55e',
                    text: 'Strong'
                },
                {
                    w: '100%',
                    bg: '#15803d',
                    text: 'Very Strong'
                },
            ];
            const lvl = levels[Math.min(score - 1, 4)] || levels[0];
            fill.style.width = lvl.w;
            fill.style.background = lvl.bg;
            label.textContent = lvl.text;
            label.style.color = lvl.bg;
        });
    </script>

@endsection
