<div class="dashboard-nav bg-white flx-between gap-md-3 gap-2">

    <div class="dashboard-nav__left flx-align gap-md-3 gap-2">
        <button type="button" class="icon-btn bar-icon text-heading bg-gray-seven flx-center">
            <i class="las la-bars"></i>
        </button>
        <button type="button" class="icon-btn arrow-icon text-heading bg-gray-seven flx-center">
            <img src="{{asset('frontend/assets/images/icons/angle-right.svg')}}" alt="">
        </button>
        <form action="#" class="search-input d-sm-block d-none">
            <span class="icon">
                <img src="{{asset('frontend/assets/images/icons/search-dark.svg')}}" alt="" class="white-version">
                <img src="{{asset('frontend/assets/images/icons/search-dark-white.svg')}}" alt="" class="dark-version">
            </span>
            <input type="text" class="common-input common-input--md common-input--bg pill w-100" placeholder="Search here...">
        </form>
    </div>
    
    <div class="dashboard-nav__right">
        <div class="header-right flx-align">
            <div class="header-right__inner gap-sm-3 gap-2 flx-align d-flex">

                <a href="{{ route('index') }}" class="btn btn-outline-light btn-sm pill flx-align gap-2" title="Back to Website">
                    <i class="las la-store"></i> Back to Website
                </a>

                <!-- Light Dark Mode -->
                <div class="theme-switch-wrapper position-relative">
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" class="d-none" id="checkbox">
                        <span class="slider text-black header-right__button white-version">
                            <img src="{{asset('frontend/assets/images/icons/sun.svg')}}" alt="">
                        </span>
                        <span class="slider text-black header-right__button dark-version">
                            <img src="{{asset('frontend/assets/images/icons/moon.svg')}}" alt="">
                        </span>
                    </label>
                </div>

                <div class="user-profile">
                    @php $__customer = Auth::guard('user')->user(); @endphp
                    <button class="user-profile__button flex-align" type="button">
                        <span class="user-profile__thumb">
                            <img src="{{ $__customer && $__customer->photo ? asset('upload/customer_images/' . $__customer->photo) : asset('frontend/assets/images/thumbs/user-profile.png') }}" class="cover-img" alt="">
                        </span>
                    </button>
                    <ul class="user-profile-dropdown">
                        <li class="sidebar-list__item">
                            <a href="{{ route('customer.profile') }}" class="sidebar-list__link">
                                <span class="text">{{ $__customer->name ?? '' }}</span>
                            </a>
                        </li>
                        <li class="sidebar-list__item">
                            <a href="{{ route('customer.logout') }}" class="sidebar-list__link">
                                <span class="text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>

      
            </div>

        </div>

    </div>

</div>
