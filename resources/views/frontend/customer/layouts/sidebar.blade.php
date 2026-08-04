<div class="dashboard-sidebar">

    <button type="button" class="dashboard-sidebar__close d-lg-none d-flex"><i class="las la-times"></i></button>

    <div class="dashboard-sidebar__inner">

        <a href="{{ route('customer.dashboard') }}" class="logo mb-48">
            <img src="{{ asset(GlobalSiteSettings()->site_header_logo ?? 'frontend/assets/images/logo/logo.png') }}" alt="" class="white-version">
            <img src="{{ asset('frontend/assets/images/logo/white-logo-two.png') }}" alt="" class="dark-version">
        </a>

        <a href="{{ route('index') }}" class="logo favicon mb-48">
            <img src="{{ asset('frontend/assets/images/logo/favicon.png') }}" alt="" style="width: 30%;">
        </a>

        <!-- Sidebar List Start -->
        <ul class="sidebar-list">

            <li class="sidebar-list__item">
                <a href="{{ route('customer.dashboard') }}" class="sidebar-list__link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <span class="sidebar-list__icon">
                        <img src="{{ asset('frontend/assets/images/icons/sidebar-icon1.svg') }}" alt="" class="icon">
                        <img src="{{ asset('frontend/assets/images/icons/sidebar-icon-active1.svg') }}" alt="" class="icon icon-active">
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-list__item">
                <a href="{{ route('customer.profile') }}" class="sidebar-list__link {{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                    <span class="sidebar-list__icon">
                        <img src="{{ asset('frontend/assets/images/icons/sidebar-icon2.svg') }}" alt="" class="icon">
                        <img src="{{ asset('frontend/assets/images/icons/sidebar-icon-active2.svg') }}" alt="" class="icon icon-active">
                    </span>
                    <span class="text">Profile</span>
                </a>
            </li>


            <li class="sidebar-list__item">
                <a href="{{ route('customer.downloads') }}" class="sidebar-list__link {{ request()->routeIs('customer.downloads') ? 'active' : '' }}">
                    <span class="sidebar-list__icon">
                        <img src="{{ asset('frontend/assets/images/icons/sidebar-icon6.svg') }}" alt="" class="icon">
                        <img src="{{ asset('frontend/assets/images/icons/sidebar-icon-active6.svg') }}" alt="" class="icon icon-active">
                    </span>
                    <span class="text">Downloads</span>
                </a>
            </li>

            <li class="sidebar-list__item">
                <a href="{{ route('customer.logout') }}" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ asset('frontend/assets/images/icons/sidebar-icon13.svg') }}" alt="" class="icon">
                        <img src="{{ asset('frontend/assets/images/icons/sidebar-icon-active13.svg') }}" alt="" class="icon icon-active">
                    </span>
                    <span class="text">Logout</span>
                </a>
            </li>

        </ul>
        <!-- Sidebar List End -->

    </div>
</div>
