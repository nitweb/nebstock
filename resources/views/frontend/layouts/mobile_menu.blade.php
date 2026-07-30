<div class="mobile-menu d-lg-none d-block">

    <button type="button" class="close-button"> <i class="las la-times"></i> </button>

    <div class="mobile-menu__inner">

        <a href="{{ route('index') }}" class="mobile-menu__logo">
            <img src="{{ asset('frontend/assets/images/logo/logo-two.png') }}" alt="Logo" class="white-version">
            <img src="{{ asset('frontend/assets/images/logo/white-logo.png') }}" alt="Logo" class="dark-version">
        </a>

        <div class="mobile-menu__menu">

            <ul class="nav-menu flx-align nav-menu--mobile">

                <li class="nav-menu__item">
                    <a href="{{ route('index') }}" class="nav-menu__link">Home</a>
                </li>

                <li class="nav-menu__item">
                    <a href="javascript:void(0)" class="nav-menu__link">Font</a>
                </li>

                <li class="nav-menu__item has-submenu">
                    <a href="javascript:void(0)" class="nav-menu__link">Mockups</a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu__item">
                            <a href="javascript:void(0)" class="nav-submenu__link"> Mockup One</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="javascript:void(0)" class="nav-submenu__link"> Mockup Two</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="javascript:void(0)" class="nav-submenu__link"> Mockup Three</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-menu__item has-submenu">
                    <a href="javascript:void(0)" class="nav-menu__link">Vectors</a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu__item">
                            <a href="javascript:void(0)" class="nav-submenu__link"> Vector One</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="javascript:void(0)" class="nav-submenu__link"> Vector Two</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-menu__item has-submenu">
                    <a href="javascript:void(0)" class="nav-menu__link">Animation</a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu__item">
                            <a href="javascript:void(0)" class="nav-submenu__link"> Animation One</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="javascript:void(0)" class="nav-submenu__link"> Animation Two</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="javascript:void(0)" class="nav-submenu__link"> Animation Three</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-menu__item">
                    <a href="javascript:void(0)" class="nav-menu__link">Web Theme</a>
                </li>

                <li class="nav-menu__item">
                    <a href="{{ route('contact') }}" class="nav-menu__link">Contact</a>
                </li>

            </ul>

            <div class="header-right__inner d-lg-none my-3 gap-1 d-flex flx-align">

                <a href="javascript:void(0)" class="btn btn-main pill">
                    <span class="icon-left icon">
                        <img src="{{ asset('frontend/assets/images/icons/user.svg') }}" alt="">
                    </span>Create Account
                </a>

            </div>

        </div>

    </div>
    
</div>