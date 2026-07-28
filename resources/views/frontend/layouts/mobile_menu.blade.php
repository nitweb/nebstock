<div class="offcanvas__header">

    <div class="offcanvas__inner">

        <div class="offcanvas__logo">
            <a class="offcanvas__logo_link" href="{{ route('index') }}">
                <img src="{{ asset(GlobalSiteSettings()->site_header_logo) }}" alt="Logo-img" width="158" height="36">
            </a>
            <button class="offcanvas__close--btn" data-offcanvas>close</button>
        </div>

        <nav class="offcanvas__menu">

            <ul class="offcanvas__menu_ul">

                <li class="offcanvas__menu_li">
                    <a class="offcanvas__menu_item" href="{{ route('index') }}">Home</a>
                </li>

                <li class="offcanvas__menu_li">
                    <a class="offcanvas__menu_item" href="{{ route('shop') }}">Shop</a>
                </li>

                <li class="offcanvas__menu_li">
                    <a class="offcanvas__menu_item" href="{{ route('product.by.category', 'clothing') }}">Clothing</a>
                </li>

                <li class="offcanvas__menu_li">
                    <a class="offcanvas__menu_item" href="{{ route('product.by.category', 'hats') }}">Hats</a>
                </li>

                <li class="offcanvas__menu_li">
                    <a class="offcanvas__menu_item" href="{{ route('product.by.category', 'books') }}">Books</a>
                </li>

            </ul>

            <div class="offcanvas__account--items">
                @auth('user')
                    <a class="offcanvas__account--items__btn d-flex align-items-center" href="{{ route('customer.dashboard') }}">
                        <span class="offcanvas__account--items__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20.51" height="19.443" viewBox="0 0 512 512">
                                <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z"
                                    fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                            </svg>
                        </span>
                        <span class="offcanvas__account--items__label">My Account</span>
                    </a>
                    <a class="offcanvas__account--items__btn d-flex align-items-center mt-2" href="{{ route('customer.logout') }}">
                        <span class="offcanvas__account--items__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <polyline points="16 17 21 12 16 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="21" y1="12" x2="9" y2="12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="offcanvas__account--items__label">Logout</span>
                    </a>
                @else
                    <a class="offcanvas__account--items__btn d-flex align-items-center" href="{{ route('customer.login') }}">
                        <span class="offcanvas__account--items__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20.51" height="19.443" viewBox="0 0 512 512">
                                <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z"
                                    fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                            </svg>
                        </span>
                        <span class="offcanvas__account--items__label">Login / Register</span>
                    </a>
                @endauth
            </div>

        </nav>

    </div>

</div>