<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Nicole Murray</title>
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

        .nm-tips {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .nm-tip {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .nm-tip-icon {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background: rgba(184, 134, 11, 0.2);
            color: #D4A017;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .nm-tip-text {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
            font-family: sans-serif;
            line-height: 1.5;
        }

        .nm-tip-text strong {
            color: rgba(255, 255, 255, 0.85);
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
            margin-bottom: 18px;
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

        .nm-input-wrap {
            position: relative;
        }

        .nm-input {
            width: 100%;
            height: 46px;
            border: 1.5px solid #E5E5E5;
            border-radius: 10px;
            padding: 0 44px 0 16px;
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

        .nm-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #aaa;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }

        .nm-toggle:hover {
            color: #555;
        }

        /* strength bar */
        .nm-strength {
            margin-top: 8px;
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .nm-strength-bar {
            height: 3px;
            flex: 1;
            border-radius: 2px;
            background: #E5E5E5;
            transition: background 0.3s;
        }

        .nm-strength-label {
            font-size: 11px;
            font-family: sans-serif;
            color: #bbb;
            min-width: 40px;
            text-align: right;
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
            margin-top: 10px;
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
            <h1 class="nm-left-headline">Set a <em>strong</em><br>new password</h1>
            <p class="nm-left-desc">Choose a secure password to protect your admin account.</p>
            <div class="nm-tips">
                <div class="nm-tip">
                    <div class="nm-tip-icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="nm-tip-text"><strong>At least 8 characters</strong> long for better security.</div>
                </div>
                <div class="nm-tip">
                    <div class="nm-tip-icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="nm-tip-text">Mix <strong>uppercase, numbers</strong> and symbols.</div>
                </div>
                <div class="nm-tip">
                    <div class="nm-tip-icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="nm-tip-text">Don't reuse a <strong>previously used password.</strong></div>
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
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
            </div>

            <h2 class="nm-form-title">Set new password</h2>
            <p class="nm-form-sub">Enter and confirm your new admin password below.</p>

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

            <form action="{{ route('admin.reset.password.submit') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="nm-field">
                    <label class="nm-label" for="password">New Password</label>
                    <div class="nm-input-wrap">
                        <input type="password" name="password" id="password" class="nm-input" placeholder="Enter new password" required>
                        <button type="button" class="nm-toggle" id="togglePwd1" aria-label="Toggle password">
                            <svg id="eye1" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    <div class="nm-strength">
                        <div class="nm-strength-bar" id="s1"></div>
                        <div class="nm-strength-bar" id="s2"></div>
                        <div class="nm-strength-bar" id="s3"></div>
                        <div class="nm-strength-bar" id="s4"></div>
                        <span class="nm-strength-label" id="sLabel"></span>
                    </div>
                </div>

                <div class="nm-field">
                    <label class="nm-label" for="password_confirmation">Confirm New Password</label>
                    <div class="nm-input-wrap">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="nm-input" placeholder="Re-enter new password" required>
                        <button type="button" class="nm-toggle" id="togglePwd2" aria-label="Toggle confirm password">
                            <svg id="eye2" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="nm-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Confirm New Password
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
    <script>
        var eyeSVG = {
            show: '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>',
            hide: '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
        };

        function makeToggle(btnId, inputId, eyeId) {
            document.getElementById(btnId).addEventListener('click', function() {
                var inp = document.getElementById(inputId);
                var isText = inp.type === 'text';
                inp.type = isText ? 'password' : 'text';
                document.getElementById(eyeId).innerHTML = isText ? eyeSVG.hide : eyeSVG.show;
            });
        }
        makeToggle('togglePwd1', 'password', 'eye1');
        makeToggle('togglePwd2', 'password_confirmation', 'eye2');

        // Password strength
        document.getElementById('password').addEventListener('input', function() {
            var v = this.value;
            var score = 0;
            if (v.length >= 8) score++;
            if (/[A-Z]/.test(v)) score++;
            if (/[0-9]/.test(v)) score++;
            if (/[^A-Za-z0-9]/.test(v)) score++;
            var colors = ['#E24B4A', '#EF9F27', '#1D9E75', '#0F6E56'];
            var labels = ['Weak', 'Fair', 'Good', 'Strong'];
            for (var i = 1; i <= 4; i++) {
                var bar = document.getElementById('s' + i);
                bar.style.background = i <= score ? colors[score - 1] : '#E5E5E5';
            }
            document.getElementById('sLabel').textContent = score > 0 ? labels[score - 1] : '';
            document.getElementById('sLabel').style.color = score > 0 ? colors[score - 1] : '#bbb';
        });
    </script>
</body>

</html>
