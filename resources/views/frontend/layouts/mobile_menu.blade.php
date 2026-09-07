<div class="mobile-menu d-lg-none d-block">

    <button type="button" class="close-button"> <i class="las la-times"></i> </button>

    <div class="mobile-menu__inner">

        <a href="{{ route('index') }}" class="mobile-menu__logo">
            <img src="{{ asset('frontend/assets/images/logo/logo-two.png') }}" alt="Logo" class="white-version">
            <img src="{{ asset('frontend/assets/images/logo/white-logo.png') }}" alt="Logo" class="dark-version">
        </a>

        <div class="mobile-menu__menu">

            @php
                $__mobileCategories = \App\Models\Category::active()->root()
                    ->with('recursiveChildren')
                    ->orderBy('sort_order')
                    ->take(6)
                    ->get();
            @endphp

            <ul class="nav-menu flx-align nav-menu--mobile">

                <li class="nav-menu__item">
                    <a href="{{ route('index') }}" class="nav-menu__link">Home</a>
                </li>

                <li class="nav-menu__item">
                    <a href="{{ route('fonts.index') }}" class="nav-menu__link">Font</a>
                </li>

                @foreach($__mobileCategories as $__cat)
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

            <div class="header-right__inner d-lg-none my-3 gap-1 d-flex flx-align">

                @php $__authUserMobile = Auth::guard('user')->user(); @endphp

                @if($__authUserMobile && $__authUserMobile->role === 'customer')
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-main pill" style="display: flex; align-items: center;">
                        <span class="icon-left icon" style="width:24px;height:24px;border-radius:50%;overflow:hidden;display:inline-flex;">
                            <img src="{{ asset('upload/customer_images/' . ($__authUserMobile->photo ?? 'avatar.png')) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
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

        </div>

    </div>

</div>