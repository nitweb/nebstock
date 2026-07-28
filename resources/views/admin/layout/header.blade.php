<header id="page-topbar">

    <div class="navbar-header">

        <div class="d-flex">

            {{-- Logo --}}
            <div class="navbar-brand-box">
                <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/favicon.png') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset(GlobalSiteSettings()->site_header_logo) }}" alt="" class="img-fluid" width="180px">
                    </span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/favicon.png') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset(GlobalSiteSettings()->site_header_logo) }}" alt="" class="img-fluid" width="180px">
                    </span>
                </a>
            </div>

            {{-- Toggle --}}
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">

            {{-- Theme Color --}}
            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            @php
                $id = Auth::guard('admin')->id();
                $profile_data = App\Models\Admin::find($id);
            @endphp
            {{-- User Profile --}}
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ !empty($profile_data->photo) ? url('upload/admin_images/' . $profile_data->photo) : url('upload/no_image.jpg') }}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ $profile_data->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="{{ route('admin.change.password') }}"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> Change Password</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                </div>
            </div>

        </div>

    </div>

</header>
