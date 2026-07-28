<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Nicole Murray</title>
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}">
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: #0D0D0D;
            font-family: 'Georgia', serif;
            display: flex;
            align-items: stretch;
            overflow: hidden;
        }

        .nm-left {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 56px 64px;
            overflow: hidden;
            min-height: 100vh;
        }

        .nm-left-bg {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.75) 100%),
                linear-gradient(135deg, #1A0E00 0%, #3D2B00 30%, #8B6914 60%, #C9952A 100%);
            z-index: 0;
        }

        .nm-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.07);
        }

        .nm-ring-1 {
            width: 420px;
            height: 420px;
            top: -100px;
            right: -120px;
        }

        .nm-ring-2 {
            width: 260px;
            height: 260px;
            top: 60px;
            right: 80px;
            border-color: rgba(255, 255, 255, 0.04);
        }

        .nm-ring-3 {
            width: 180px;
            height: 180px;
            bottom: 120px;
            left: -60px;
        }

        .nm-left-content {
            position: relative;
            z-index: 2;
        }

        .nm-left-eyebrow {
            font-size: 11px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(255, 215, 100, 0.7);
            font-family: sans-serif;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .nm-left-headline {
            font-size: 42px;
            line-height: 1.15;
            color: #fff;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .nm-left-headline em {
            font-style: italic;
            color: #D4A017;
        }

        .nm-left-desc {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.7;
            font-family: sans-serif;
            max-width: 340px;
            margin-bottom: 40px;
        }

        .nm-steps {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .nm-step {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .nm-step-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(184, 134, 11, 0.25);
            border: 1px solid rgba(184, 134, 11, 0.5);
            color: #D4A017;
            font-size: 12px;
            font-weight: 700;
            font-family: sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .nm-step-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            font-family: sans-serif;
            line-height: 1.5;
        }

        .nm-step-text strong {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }

        .nm-right {
            width: 480px;
            flex-shrink: 0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 56px;
            position: relative;
        }

        .nm-right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #B8860B, #D4A017, #8B6914);
        }

        .nm-form-wrap {
            width: 100%;
        }

        .nm-logo-wrap {
            text-align: center;
            margin-bottom: 32px;
        }

        .nm-logo-wrap img {
            max-width: 160px;
        }

        .nm-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: #F5ECD0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #B8860B;
        }

        .nm-form-title {
            font-size: 22px;
            font-weight: 700;
            color: #1A1A1A;
            margin-bottom: 6px;
            text-align: center;
        }

        .nm-form-sub {
            font-size: 14px;
            color: #999;
            text-align: center;
            font-family: sans-serif;
            margin-bottom: 28px;
            line-height: 1.6;
        }

        .nm-alert {
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            font-family: sans-serif;
            margin-bottom: 20px;
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

        .nm-field {
            margin-bottom: 20px;
        }

        .nm-label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            font-family: sans-serif;
            letter-spacing: 0.2px;
            display: block;
            margin-bottom: 8px;
        }

        .nm-input {
            width: 100%;
            height: 46px;
            border: 1.5px solid #E5E5E5;
            border-radius: 10px;
            padding: 0 16px;
            font-size: 14px;
            font-family: sans-serif;
            color: #1A1A1A;
            background: #FAFAFA;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        .nm-input:focus {
            border-color: #B8860B;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
        }

        .nm-btn {
            width: 100%;
            height: 48px;
            background: #1A1A1A;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: sans-serif;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .nm-btn:hover {
            background: #B8860B;
            transform: translateY(-1px);
        }

        .nm-btn:active {
            transform: translateY(0);
        }

        .nm-back {
            margin-top: 24px;
            text-align: center;
            font-size: 13px;
            font-family: sans-serif;
            color: #aaa;
        }

        .nm-back a {
            color: #B8860B;
            text-decoration: none;
            font-weight: 600;
        }

        .nm-back a:hover {
            text-decoration: underline;
        }

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
    </style>
</head>

<body>

    <div class="nm-left">
        <div class="nm-left-bg"></div>
        <div class="nm-ring nm-ring-1"></div>
        <div class="nm-ring nm-ring-2"></div>
        <div class="nm-ring nm-ring-3"></div>
        <div class="nm-left-content">
            <p class="nm-left-eyebrow">Nicole Murray Admin</p>
            <h1 class="nm-left-headline">Recover your<br>account <em>easily</em></h1>
            <p class="nm-left-desc">Follow these simple steps to reset your admin password securely.</p>
            <div class="nm-steps">
                <div class="nm-step">
                    <div class="nm-step-num">1</div>
                    <div class="nm-step-text"><strong>Enter your email</strong> address associated with your admin account.</div>
                </div>
                <div class="nm-step">
                    <div class="nm-step-num">2</div>
                    <div class="nm-step-text"><strong>Check your inbox</strong> for a secure password reset link.</div>
                </div>
                <div class="nm-step">
                    <div class="nm-step-num">3</div>
                    <div class="nm-step-text"><strong>Set a new password</strong> and sign back into your dashboard.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="nm-right">
        <div class="nm-form-wrap">

            <div class="nm-logo-wrap">
                <a href="{{ route('index') }}" target="_blank">
                    <img src="{{ asset(GlobalSiteSettings()->site_header_logo) }}" alt="Nicole Murray">
                </a>
            </div>

            <div class="nm-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
            </div>

            <h2 class="nm-form-title">Forgot password?</h2>
            <p class="nm-form-sub">No worries! Enter your email and we'll send you a reset link.</p>

            @if ($errors->any())
                <div class="nm-alert nm-alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="nm-alert nm-alert-error">
                    <ul>
                        <li>{{ Session::get('error') }}</li>
                    </ul>
                </div>
            @endif
            @if (Session::has('success'))
                <div class="nm-alert nm-alert-success">
                    <ul>
                        <li>{{ Session::get('success') }}</li>
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.forget.password.submit') }}" method="post">
                @csrf
                <div class="nm-field">
                    <label class="nm-label" for="email">Email address</label>
                    <input type="email" name="email" id="email" class="nm-input" placeholder="admin@example.com" autocomplete="email" required>
                </div>
                <button type="submit" class="nm-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13" />
                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                    </svg>
                    Send Reset Link
                </button>
            </form>

            <div class="nm-back">
                <a href="{{ route('admin.login') }}">← Back to Sign In</a>
            </div>

        </div>
    </div>

    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/pace-js/pace.min.js') }}"></script>
</body>

</html>
