<div class="top-bar">
    <style>
        .top-bar {
            background: #f3f4f8;
            border-bottom: 1px solid #e5e7eb;
        }

        .top-bar__inner {
            padding: 10px 0;
        }

        .top-bar__contact {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .top-bar__contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6b7280;
            text-decoration: none;
        }

        .top-bar__contact-item i {
            font-size: 13px;
            color: #6b7280;
        }

        .top-bar__contact-item:hover {
            color: #1f2937;
        }

        .top-bar__links {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .top-bar__link {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            text-decoration: none;
        }

        .top-bar__link:hover {
            color: var(--main-color, #1f2937);
        }

        @media (max-width: 767px) {
            .top-bar__contact {
                gap: 14px;
            }
            .top-bar__links {
                gap: 14px;
            }
            .top-bar__contact-item span {
                display: none;
            }
        }
    </style>

    <div class="container container-full">
        <div class="top-bar__inner flx-between gap-3 flex-wrap">

            <div class="top-bar__contact">
                @if(GlobalSiteSettings()->site_phone)
                <a href="tel:{{ GlobalSiteSettings()->site_phone }}" class="top-bar__contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>{{ GlobalSiteSettings()->site_phone }}</span>
                </a>
                @endif

                @if(GlobalSiteSettings()->site_email)
                <a href="mailto:{{ GlobalSiteSettings()->site_email }}" class="top-bar__contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>{{ GlobalSiteSettings()->site_email }}</span>
                </a>
                @endif
            </div>

            <div class="top-bar__links">
                @auth('user')
                    <a href="{{ route('customer.downloads') }}" class="top-bar__link">My Downloads</a>
                    <a href="{{ route('customer.dashboard') }}" class="top-bar__link">My Account</a>
                @else
                    <a href="{{ route('customer.login') }}" class="top-bar__link">My Account</a>
                @endauth
            </div>

        </div>
    </div>
</div>