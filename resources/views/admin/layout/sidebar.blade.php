<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title" data-key="t-menu">Menu</li>

                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Slider --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="image"></i>
                        <span>Slider</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.slider.list') }}">List</a></li>
                    </ul>
                </li>

                {{-- Product Manage --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="shopping-cart"></i>
                        <span>Product Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.categories.list') }}">Category List</a></li>
                        <li><a href="{{ route('backend.authors.list') }}">Author List</a></li>
                        <li><a href="{{ route('backend.products.list') }}">Product List</a></li>
                    </ul>
                </li>

                {{-- Product Reviews --}}
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="star"></i>
                        <span>Product Reviews</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.reviews.list') }}">Review List</a></li>
                    </ul>
                </li> --}}

                {{-- Orders --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="shopping-bag"></i>
                        <span>Order Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.orders.list') }}">Order List</a></li>
                    </ul>
                </li>

                {{-- Coupon --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="tag"></i>
                        <span>Coupon</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.coupon.list') }}">Coupon List</a></li>
                        <li><a href="{{ route('backend.coupon.add') }}">Add Coupon</a></li>
                    </ul>
                </li>

                {{-- Newsletter --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="send"></i>
                        <span>Newsletter</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.newsletter.list') }}">Subscribers List</a></li>
                    </ul>
                </li>

                {{-- Blog --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="edit-3"></i>
                        <span>Blog</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.blog_categories.list') }}">Blog Categories</a></li>
                        <li><a href="{{ route('backend.blog.list') }}">Blog List</a></li>
                    </ul>
                </li>

                {{-- Contact --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span>Contact Forms</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.contact_form.list') }}">List</a></li>
                    </ul>
                </li>

                {{-- About / Mission --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="info"></i>
                        <span>About & Mission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.about_company.list') }}">About Company</a></li>
                        <li><a href="{{ route('backend.mission_vision.list') }}">Mission / Vision</a></li>
                    </ul>
                </li>

                {{-- About / Mission --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span>Customer</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.customers.list') }}">Customer List</a></li>
                    </ul>
                </li>

                {{-- Settings --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="settings"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.site_settings.font_awesome') }}">Font Awesome</a></li>
                        <li><a href="{{ route('backend.site_settings') }}">Site Settings</a></li>
                    </ul>
                </li>

                {{-- Analytics --}}
                <li>
                    <a href="{{ url('/analytics') }}" target="_blank">
                        <i data-feather="bar-chart-2"></i>
                        <span>Analytics</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
