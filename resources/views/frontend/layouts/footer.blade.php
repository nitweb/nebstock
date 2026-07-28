<footer class="footer__section">

    <style>
        .footer__section {
            background: var(--bg-black-color);
            color: var(--bg-offwhite-color);
            font-family: var(--frank-ruhl-fonts);
            overflow: hidden;
        }

        .footer__decor-line {
            height: 3px;
            background: linear-gradient(90deg, var(--bg-black-color), var(--secondary-color) 30%, var(--yellow-color) 50%, var(--secondary-color) 70%, var(--bg-black-color));
        }

        .footer__ornament {
            text-align: center;
            padding: 2rem 0 0;
            letter-spacing: 0.4em;
            color: var(--secondary-color);
            font-size: 1.3rem;
            opacity: 0.7;
        }

        .footer__divider {
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--secondary-color), transparent);
            margin: 1.2rem 0;
        }

        .main__footer {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1.6fr;
            gap: 3rem;
            padding: 1.5rem 0 2.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (max-width: 991px) {
            .main__footer {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 575px) {
            .main__footer {
                grid-template-columns: 1fr;
            }
        }

        .footer__brand-name {
            font-size: 3.2rem;
            color: var(--secondary-color);
            letter-spacing: 0.05em;
            font-style: italic;
            line-height: 1.1;
            margin-bottom: 0.3rem;
        }

        .footer__brand-tagline {
            font-size: 1.1rem;
            letter-spacing: 0.25em;
            color: var(--foreground-sub-color);
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            font-family: var(--karma-fonts);
        }

        .footer__widget--desc {
            font-size: 1.4rem;
            color: #aaaaaa;
            line-height: 1.8;
            margin-bottom: 1.8rem;
            font-family: var(--karma-fonts);
        }

        .footer__widget--info {
            list-style: none;
            padding: 0;
        }

        .footer__widget--info_list {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 0.8rem;
        }

        .footer__widget--info__icon {
            color: var(--secondary-color);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .footer__widget--info__text {
            font-size: 1.3rem;
            color: #bbbbbb;
            font-family: var(--karma-fonts);
            line-height: 1.5;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer__widget--info__text:hover {
            color: var(--yellow-color);
        }

        .footer__widget--title {
            /* font-size: 1.1rem; */
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--secondary-color);
            margin-bottom: 1.8rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #2a2a2a;
            font-family: var(--karma-fonts);
            font-weight: 600;
        }

        .footer__widget--menu {
            list-style: none;
            padding: 0;
        }

        .footer__widget--menu__list {
            margin-bottom: 0.8rem;
        }

        .footer__widget--menu__text {
            color: #aaaaaa;
            text-decoration: none;
            font-size: 1.4rem;
            font-family: var(--karma-fonts);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .footer__widget--menu__text::before {
            content: '›';
            color: var(--secondary-color);
            opacity: 0;
            transition: var(--transition);
        }

        .footer__widget--menu__text:hover {
            color: var(--yellow-color);
            padding-left: 6px;
        }

        .footer__widget--menu__text:hover::before {
            opacity: 1;
        }

        .newsletter__subscribe--form {
            display: flex;
            border: 1px solid #333333;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 1.8rem;
        }

        .newsletter__subscribe--input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 1rem 1.4rem;
            color: var(--bg-offwhite-color);
            font-size: 1.3rem;
            outline: none;
            font-family: var(--karma-fonts);
        }

        .newsletter__subscribe--input::placeholder {
            color: #555;
        }

        .newsletter__subscribe--button {
            background: var(--secondary-color);
            border: none;
            padding: 1rem 1.8rem;
            color: var(--bg-black-color);
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            font-family: var(--karma-fonts);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: var(--transition);
            white-space: nowrap;
        }

        .newsletter__subscribe--button:hover {
            background: var(--yellow-color);
        }

        .social__share {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 8px;
        }

        .social__share--icon {
            width: 34px;
            height: 34px;
            border: 1px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 2px;
            transition: var(--transition);
            text-decoration: none;
            color: #aaaaaa;
        }

        .social__share--icon:hover {
            border-color: var(--secondary-color);
            background: rgba(184, 134, 11, 0.1);
            color: var(--yellow-color);
        }

        .social__share--icon svg {
            fill: currentColor;
        }

        .footer__quote-strip {
            border: 1px solid #2a2a2a;
            border-left: 3px solid var(--secondary-color);
            padding: 1.2rem 1.8rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            margin-bottom: 2rem;
            border-radius: 2px;
        }

        .footer__quote-mark {
            color: var(--secondary-color);
            font-size: 2.8rem;
            font-style: italic;
            line-height: 1;
            opacity: 0.6;
            font-family: Georgia, serif;
            flex-shrink: 0;
        }

        .footer__quote-text {
            /* font-size: 1.2rem; */
            color: #888;
            font-style: italic;
            line-height: 1.6;
            font-family: var(--frank-ruhl-fonts);
        }

        .footer__bottom {
            border-top: 1px solid #262626;
        }

        .footer__bottom--inenr {
            padding: 1.5rem 0;
        }

        .copyright__content {
            /* font-size: 1.2rem; */
            color: #666;
            font-family: var(--karma-fonts);
        }

        .copyright__content .text__secondary {
            color: var(--secondary-color);
        }

        .copyright__content--link {
            color: #666;
            text-decoration: none;
        }

        .copyright__content--link:hover {
            color: var(--secondary-color);
        }

        .footer__payment {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .pay-badge {
            background: #262626;
            border: 1px solid #333;
            border-radius: 3px;
            padding: 4px 10px;
            font-size: 1rem;
            color: #888;
            font-family: var(--karma-fonts);
            font-weight: 700;
            letter-spacing: 0.05em;
        }
    </style>

    <div class="footer__decor-line"></div>
    <div class="footer__ornament">✦ &nbsp; &nbsp; ✦ &nbsp; &nbsp; ✦</div>
    <div class="footer__divider"></div>

    <div class="container">

        <div class="main__footer">

            {{-- Column 1: Brand + Contact --}}
            <div class="footer__widget">

                <div class="main__logo mb-3">
                    <h1 class="main__logo--title">
                        <a class="main__logo--link" href="{{ route('index') }}">
                            <img class="main__logo--img img-fluid" src="{{ asset(GlobalSiteSettings()->site_footer_logo) }}" alt="Site Logo" style="width: 200px;">
                        </a>
                    </h1>
                </div>

                <div class="footer__widget--desc" style="text-align: justify;">
                    {{ GlobalSiteSettings()->site_description }}
                </div>

                <ul class="footer__widget--info">

                    <li class="footer__widget--info_list">
                        <svg class="footer__widget--info__icon" width="20" height="23" viewBox="0 0 20 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.3334 10.1666C18.3334 14.769 10.0001 20.9999 10.0001 20.9999C10.0001 20.9999 1.66675 14.769 1.66675 10.1666C1.66675 5.56421 5.39771 1.83325 10.0001 1.83325C14.6025 1.83325 18.3334 5.56421 18.3334 10.1666Z" stroke="currentColor" stroke-width="2" />
                            <ellipse cx="10.0001" cy="10.1667" rx="2.5" ry="2.5" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <span class="footer__widget--info__text">{{ GlobalSiteSettings()->site_address }}</span>
                    </li>

                    <li class="footer__widget--info_list">
                        <svg class="footer__widget--info__icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.31 1.52371L18.6133 2.11296C18.6133 2.11296 19.2026 7.41627 13.31 13.3088C7.41748 19.2014 2.11303 18.6133 2.11303 18.6133L1.52377 13.31L5.64971 10.9529L7.71153 13.0148C7.71153 13.0148 9.18467 12.7201 10.9524 10.9524C12.7202 9.18461 13.0148 7.71147 13.0148 7.71147L10.953 5.64965L13.31 1.52371Z" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <a class="footer__widget--info__text" href="tel:{{ GlobalSiteSettings()->site_phone }}">{{ GlobalSiteSettings()->site_phone }}</a>
                        <span class="text__secondary">/</span>
                        <a class="footer__widget--info__text" href="tel:{{ GlobalSiteSettings()->site_phone_alt }}">{{ GlobalSiteSettings()->site_phone_alt }}</a>
                    </li>

                    <li class="footer__widget--info_list">
                        <svg class="footer__widget--info__icon" width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.00006 3.33325H22.0001V17.4999H2.00006V3.33325Z" stroke="currentColor" stroke-width="2" />
                            <path d="M3.2655 3.33325H20.7871L12 12.4999L3.2655 3.33325Z" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <a class="footer__widget--info__text" href="mailto:{{ GlobalSiteSettings()->site_email }}">{{ GlobalSiteSettings()->site_email }}</a>
                        <span class="text__secondary">/</span>
                        <a class="footer__widget--info__text" href="mailto:{{ GlobalSiteSettings()->site_email_alt }}">{{ GlobalSiteSettings()->site_email_alt }}</a>
                    </li>

                </ul>

            </div>

            {{-- Column 2: Our Offer --}}
            <div class="footer__widget">
                <h2 class="footer__widget--title">Quick Links</h2>
                <ul class="footer__widget--menu">
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('customer.dashboard') }}">My Account</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('customer.login') }}">Login/Register</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('about') }}">About Us</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('shop') }}">Shop</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('blog') }}">Blog</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('contact') }}">Contact Us</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('wishlist') }}">Wishlist</a></li>
                </ul>
            </div>

            {{-- Column 3: Policies --}}
            <div class="footer__widget">
                <h2 class="footer__widget--title">Policies</h2>
                <ul class="footer__widget--menu">
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('data.usage') }}">Data Usage</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('refund.conditions') }}">Refund Conditions</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('shipping.policies') }}">Shipping Policies</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('international.returns') }}">International Returns</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('return.policy') }}">Return Policy</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('terms.conditions') }}">Terms & Conditions</a></li>
                    <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                </ul>
            </div>

            {{-- Column 4: Newsletter --}}
            @include('frontend.partials.newsletter_widget')

        </div>

    </div>

    <div class="footer__bottom">
        <div class="container">
            <div class="footer__bottom--inenr d-flex justify-content-between align-items-center flex-wrap gap-3">
                <p class="copyright__content mb-0">
                    {{ GlobalSiteSettings()->site_copyright }}. All Rights Reserved. Developed by <a class="copyright__content--link" target="_blank" href="https://web.nebulaitbd.com/">Nebula IT</a>.
                </p>
                <div class="footer__payment d-flex gap-2 align-items-center">
                    <img src="{{ asset('frontend/assets/img/icon/payment-img.webp') }}" alt="Payment Img">
                </div>
            </div>
        </div>
    </div>

</footer>
