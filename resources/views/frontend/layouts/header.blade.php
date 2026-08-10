<header class="header">

    <div class="container container-full">

        <nav class="header-inner flx-between">

            <!-- Logo Start -->
            <div class="logo">
                <a href="{{ route('index') }}" class="link white-version">
                    <img src="{{ asset(GlobalSiteSettings()->site_header_logo) }}" alt="Logo">
                </a>
                <a href="{{ route('index') }}" class="link dark-version">
                    <img src="{{ asset('frontend/assets/images/logo/white-logo.png') }}" alt="Logo">
                </a>
            </div>
            <!-- Logo End  -->

            <!-- Menu Start  -->
            <div class="header-menu d-lg-block d-none">

                @php
                    $__headerCategories = \App\Models\Category::active()->root()
                        ->with('recursiveChildren')
                        ->orderBy('sort_order')
                        ->take(6)
                        ->get();
                @endphp

                <ul class="nav-menu flx-align ">

                    <li class="nav-menu__item">
                        <a href="{{ route('index') }}" class="nav-menu__link">Home</a>
                    </li>

                    <li class="nav-menu__item">
                        <a href="javascript:void(0)" class="nav-menu__link">Font</a>
                    </li>

                    @foreach($__headerCategories as $__cat)
                        @if($__cat->recursiveChildren->count())
                            <li class="nav-menu__item has-submenu">
                                <a href="{{ route('product.by.category', $__cat->slug) }}" class="nav-menu__link">{{ $__cat->name }}</a>
                                <ul class="nav-submenu">
                                    @foreach($__cat->recursiveChildren as $__child)
                                        <li class="nav-submenu__item">
                                            <a href="{{ route('product.by.category', $__child->slug) }}" class="nav-submenu__link"> {{ $__child->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-menu__item">
                                <a href="{{ route('product.by.category', $__cat->slug) }}" class="nav-menu__link">{{ $__cat->name }}</a>
                            </li>
                        @endif
                    @endforeach

                    <li class="nav-menu__item">
                        <a href="{{ route('contact') }}" class="nav-menu__link">Contact</a>
                    </li>

                </ul>

            </div>
            <!-- Menu End  -->

            <!-- Header Right start -->
            <div class="header-right flx-align">

                <!-- Light Dark Mode -->
                <div class="theme-switch-wrapper position-relative">
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" class="d-none" id="checkbox">
                        <span class="slider text-black header-right__button white-version">
                            <img src="{{ asset('frontend/assets/images/icons/sun.svg') }}" alt="">
                        </span>
                        <span class="slider text-black header-right__button dark-version">
                            <img src="{{ asset('frontend/assets/images/icons/moon.svg') }}" alt="">
                        </span>
                    </label>
                </div>

                <div class="header-right__inner gap-3 flx-align d-lg-flex d-none">

                    @php $__authUser = Auth::guard('user')->user(); @endphp

                    @if($__authUser && $__authUser->role === 'customer')
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-main pill" style="display: flex; align-items: center;">
                            <span class="icon-left icon" style="width:24px;height:24px;border-radius:50%;overflow:hidden;display:inline-flex;">
                                <img src="{{ asset('upload/customer_images/' . ($__authUser->photo ?? 'avatar.png')) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                            </span>Dashboard
                        </a>
                    @else
                        <a href="{{ route('customer.register') }}" class="btn btn-main pill">
                            <span class="icon-left icon">
                                <img src="{{ asset('frontend/assets/images/icons/user.svg') }}" alt="">
                            </span>Create Account
                        </a>
                    @endif
                </div>

                <button type="button" class="toggle-mobileMenu d-lg-none"> <i class="las la-bars"></i> </button>

            </div>
            <!-- Header Right End  -->

        </nav>

    </div>

</header>