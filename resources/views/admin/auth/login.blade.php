<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | {{ GlobalSiteSettings()->site_name ?? 'Nicole Murray' }}</title>
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}">

    {{-- Bootstrap & backend assets --}}
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --gold: #C9952A;
            --gold-deep: #8B6914;
            --gold-light: #F0C84A;
            --dark: #0D0D0D;
            --ink: #1A1A1A;
            --border: #E8E2D9;
            --muted: #9A9187;
            --bg: #FDFBF8;
        }

        body {
            min-height: 100vh;
            background: var(--dark);
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: stretch;
            overflow: hidden;
        }

        /* ── Left Panel ─────────────────────────── */
        .nm-left {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 52px 64px;
            overflow: hidden;
            min-height: 100vh;
        }

        .nm-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 80% 20%, rgba(201, 149, 42, 0.28) 0%, transparent 65%),
                radial-gradient(ellipse 50% 70% at 10% 80%, rgba(139, 105, 20, 0.22) 0%, transparent 60%),
                linear-gradient(160deg, #0D0800 0%, #1C1100 40%, #261800 70%, #0D0800 100%);
            z-index: 0;
        }

        /* grain overlay */
        .nm-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.045'/%3E%3C/svg%3E");
            background-size: 180px;
            z-index: 1;
            pointer-events: none;
        }

        .nm-arc {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(201, 149, 42, 0.12);
            z-index: 2;
        }

        .nm-arc-1 {
            width: 560px;
            height: 560px;
            top: -180px;
            right: -160px;
        }

        .nm-arc-2 {
            width: 340px;
            height: 340px;
            top: 40px;
            right: 50px;
            border-color: rgba(201, 149, 42, 0.06);
        }

        .nm-arc-3 {
            width: 200px;
            height: 200px;
            bottom: 100px;
            left: -80px;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .nm-left-top {
            position: relative;
            z-index: 3;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nm-left-top-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            opacity: 0.8;
        }

        .nm-left-top-label {
            font-size: 10px;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: rgba(201, 149, 42, 0.65);
            font-weight: 500;
        }

        .nm-left-content {
            position: relative;
            z-index: 3;
        }

        .nm-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .nm-eyebrow-line {
            width: 28px;
            height: 1px;
            background: var(--gold);
            opacity: 0.6;
        }

        .nm-eyebrow-text {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(201, 149, 42, 0.7);
            font-weight: 500;
        }

        .nm-headline {
            font-family: 'Cormorant Garamond', serif;
            font-size: 52px;
            line-height: 1.1;
            color: #fff;
            font-weight: 600;
            letter-spacing: -0.5px;
            margin-bottom: 22px;
        }

        .nm-headline em {
            font-style: italic;
            color: var(--gold);
            font-weight: 400;
        }

        .nm-desc {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.42);
            line-height: 1.75;
            max-width: 320px;
            margin-bottom: 48px;
            font-weight: 300;
        }

        .nm-pillars {
            display: flex;
            align-items: center;
        }

        .nm-pillar {
            padding: 0 28px 0 0;
        }

        .nm-pillar:first-child {
            padding-left: 0;
        }

        .nm-pillar-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 30px;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            margin-bottom: 4px;
        }

        .nm-pillar-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 0.5px;
        }

        .nm-pillar-sep {
            width: 1px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            margin-right: 28px;
            flex-shrink: 0;
        }

        .nm-left-bottom {
            position: relative;
            z-index: 3;
        }

        .nm-watermark {
            font-family: 'Cormorant Garamond', serif;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.18);
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        /* ── Right Panel ─────────────────────────── */
        .nm-right {
            width: 460px;
            flex-shrink: 0;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 52px 52px;
            position: relative;
            box-shadow: -20px 0 60px rgba(0, 0, 0, 0.4);
        }

        .nm-right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent 0%, var(--gold-deep) 20%, var(--gold) 50%, var(--gold-deep) 80%, transparent 100%);
        }

        .nm-right::after {
            content: '';
            position: absolute;
            bottom: 40px;
            right: 40px;
            width: 80px;
            height: 80px;
            border-bottom: 1px solid rgba(201, 149, 42, 0.12);
            border-right: 1px solid rgba(201, 149, 42, 0.12);
            border-radius: 0 0 8px 0;
        }

        .nm-form-wrap {
            width: 100%;
        }

        /* logo */
        .nm-logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 36px;
        }

        .nm-logo-ring {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 1.5px solid rgba(201, 149, 42, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            background: #fff;
            box-shadow: 0 2px 16px rgba(201, 149, 42, 0.08);
            overflow: hidden;
        }

        .nm-logo-ring img {
            max-width: 48px;
            max-height: 48px;
            object-fit: contain;
        }

        .nm-logo-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 13px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--ink);
            font-weight: 600;
        }

        .nm-logo-tagline {
            font-size: 10px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-top: 3px;
        }

        .nm-form-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            font-weight: 600;
            color: var(--ink);
            text-align: center;
            margin-bottom: 4px;
        }

        .nm-form-sub {
            font-size: 13px;
            color: var(--muted);
            text-align: center;
            margin-bottom: 28px;
            font-weight: 300;
        }

        /* divider */
        .nm-section-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .nm-section-divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .nm-section-divider-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--gold);
            opacity: 0.5;
        }

        /* alerts */
        .nm-alert {
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .nm-alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
        }

        .nm-alert-success {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #166534;
        }

        .nm-alert ul {
            padding-left: 16px;
            margin: 0;
        }

        /* fields */
        .nm-field {
            margin-bottom: 18px;
        }

        .nm-field-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 7px;
        }

        .nm-label {
            font-size: 12px;
            font-weight: 500;
            color: #555;
            letter-spacing: 0.3px;
        }

        .nm-forgot {
            font-size: 11px;
            color: var(--gold-deep);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }

        .nm-forgot:hover {
            color: var(--gold);
        }

        .nm-input-wrap {
            position: relative;
        }

        .nm-input {
            width: 100%;
            height: 48px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 0 16px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .nm-input::placeholder {
            color: #C5BFB8;
        }

        .nm-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 149, 42, 0.1);
        }

        .nm-input.has-icon {
            padding-right: 46px;
        }

        .nm-input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #C5BFB8;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }

        .nm-input-icon:hover {
            color: var(--gold-deep);
        }

        /* submit btn */
        .nm-btn {
            width: 100%;
            height: 50px;
            background: var(--ink);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: box-shadow 0.25s, transform 0.15s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .nm-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--gold-deep), var(--gold));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .nm-btn:hover::before {
            opacity: 1;
        }

        .nm-btn:hover {
            box-shadow: 0 6px 20px rgba(201, 149, 42, 0.35);
            transform: translateY(-1px);
        }

        .nm-btn:active {
            transform: translateY(0);
        }

        .nm-btn svg,
        .nm-btn span {
            position: relative;
            z-index: 1;
        }

        /* footer */
        .nm-footer {
            margin-top: 28px;
            text-align: center;
        }

        .nm-footer-link {
            font-size: 12px;
            color: var(--muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: color 0.15s;
        }

        .nm-footer-link:hover {
            color: var(--gold-deep);
        }

        .nm-footer-link svg {
            transition: transform 0.2s;
        }

        .nm-footer-link:hover svg {
            transform: translateX(-3px);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .nm-left {
                display: none;
            }

            .nm-right {
                width: 100%;
                min-height: 100vh;
                padding: 40px 28px;
            }
        }

        /* entrance animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nm-form-wrap>* {
            animation: fadeUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .nm-logo-wrap {
            animation-delay: 0.05s;
        }

        .nm-form-title {
            animation-delay: 0.10s;
        }

        .nm-form-sub {
            animation-delay: 0.13s;
        }

        .nm-section-divider {
            animation-delay: 0.16s;
        }

        .nm-field:nth-child(4) {
            animation-delay: 0.18s;
        }

        .nm-field:nth-child(5) {
            animation-delay: 0.22s;
        }

        .nm-btn {
            animation-delay: 0.27s;
        }

        .nm-footer {
            animation-delay: 0.30s;
        }

        @keyframes fadeRight {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .nm-left-top {
            animation: fadeRight 0.6s 0.10s ease both;
        }

        .nm-eyebrow {
            animation: fadeRight 0.6s 0.20s ease both;
        }

        .nm-headline {
            animation: fadeRight 0.7s 0.30s ease both;
        }

        .nm-desc {
            animation: fadeRight 0.7s 0.40s ease both;
        }

        .nm-pillars {
            animation: fadeRight 0.7s 0.50s ease both;
        }
    </style>
</head>

<body>

    {{-- ── Left decorative panel ── --}}
    <div class="nm-left">
        <div class="nm-arc nm-arc-1"></div>
        <div class="nm-arc nm-arc-2"></div>
        <div class="nm-arc nm-arc-3"></div>

        <div class="nm-left-top">
            <div class="nm-left-top-dot"></div>
            <span class="nm-left-top-label">Admin Portal</span>
        </div>

        <div class="nm-left-content">
            <div class="nm-eyebrow">
                <div class="nm-eyebrow-line"></div>
                <span class="nm-eyebrow-text">{{ GlobalSiteSettings()->site_name ?? 'Nicole Murray' }}</span>
            </div>

            <h1 class="nm-headline">
                Manage your<br>
                store with <em>style</em>
            </h1>

            <p class="nm-desc">
                Full control over your products, orders, blogs, and customers — all from one elegant dashboard.
            </p>

            <div class="nm-pillars">
                <div class="nm-pillar">
                    <div class="nm-pillar-value">19+</div>
                    <div class="nm-pillar-label">Products</div>
                </div>
                <div class="nm-pillar-sep"></div>
                <div class="nm-pillar">
                    <div class="nm-pillar-value">100%</div>
                    <div class="nm-pillar-label">Secure</div>
                </div>
                <div class="nm-pillar-sep"></div>
                <div class="nm-pillar">
                    <div class="nm-pillar-value">24/7</div>
                    <div class="nm-pillar-label">Live Store</div>
                </div>
            </div>
        </div>

        <div class="nm-left-bottom">
            <p class="nm-watermark">
                {{ GlobalSiteSettings()->site_tagline ?? 'Family · Love · Respect' }}
            </p>
        </div>
    </div>

    {{-- ── Right login panel ── --}}
    <div class="nm-right">
        <div class="nm-form-wrap">

            {{-- Logo --}}
            <div class="nm-logo-wrap">
                <a href="{{ route('index') }}" target="_blank">
                    <div class="nm-logo-ring">
                        <img src="{{ asset('frontend/assets/img/favicon.png') }}">
                    </div>
                </a>
                <div class="nm-logo-name">
                    {{ GlobalSiteSettings()->site_name ?? 'Nicole Murray' }}
                </div>
                <div class="nm-logo-tagline">
                    {{ GlobalSiteSettings()->site_tagline ?? 'Family · Love · Respect' }}
                </div>
            </div>

            <h2 class="nm-form-title">Welcome back</h2>
            <p class="nm-form-sub">Sign in to your admin dashboard</p>

            <div class="nm-section-divider">
                <div class="nm-section-divider-line"></div>
                <div class="nm-section-divider-dot"></div>
                <div class="nm-section-divider-line"></div>
            </div>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="nm-alert nm-alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Session error --}}
            @if (Session::has('error'))
                <div class="nm-alert nm-alert-error">
                    <ul>
                        <li>{{ Session::get('error') }}</li>
                    </ul>
                </div>
            @endif

            {{-- Session success --}}
            @if (Session::has('success'))
                <div class="nm-alert nm-alert-success">
                    <ul>
                        <li>{{ Session::get('success') }}</li>
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="post">
                @csrf

                <div class="nm-field">
                    <div class="nm-field-header">
                        <label class="nm-label" for="email">Email Address</label>
                    </div>
                    <input type="email" name="email" id="email" class="nm-input @error('email') is-invalid @enderror" placeholder="admin@example.com" value="{{ old('email') }}" autocomplete="email" required>
                </div>

                <div class="nm-field">
                    <div class="nm-field-header">
                        <label class="nm-label" for="password">Password</label>
                    </div>
                    <div class="nm-input-wrap">
                        <input type="password" name="password" id="password" class="nm-input has-icon @error('password') is-invalid @enderror" placeholder="Enter your password" autocomplete="current-password" required>
                        <button type="button" class="nm-input-icon" id="togglePwd" aria-label="Toggle password visibility">
                            <svg id="eyeIcon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="nm-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    <span>Sign In</span>
                </button>
            </form>

            <div class="nm-footer">
                <a href="{{ route('index') }}" target="_blank" class="nm-footer-link">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    Back to Website
                </a>
            </div>

        </div>
    </div>

    {{-- Backend JS assets --}}
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/pace-js/pace.min.js') }}"></script>

    <script>
        document.getElementById('togglePwd').addEventListener('click', function() {
            var inp = document.getElementById('password');
            var isText = inp.type === 'text';
            inp.type = isText ? 'password' : 'text';
            document.getElementById('eyeIcon').innerHTML = isText ?
                '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>' :
                '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        });
    </script>

</body>

</html>
