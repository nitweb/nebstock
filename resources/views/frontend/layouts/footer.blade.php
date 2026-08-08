<footer class="footer-section">

    <img src="{{ asset('frontend/assets/images/shapes/pattern.png') }}" alt="" class="bg-pattern">
    <img src="{{ asset('frontend/assets/images/gradients/footer-gradient.png') }}" alt="" class="bg--gradient">

    <div class="container container-two">

        <div class="row gy-5">

            <div class="col-xl-3 col-sm-6">
                <div class="footer-widget">
                    <div class="footer-widget__logo">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset(GlobalSiteSettings()->site_footer_logo ?? 'frontend/assets/images/logo/white-logo.png') }}" alt="Site Logo">
                        </a>
                    </div>
                    <p class="footer-widget__desc">{{ GlobalSiteSettings()->site_description }}</p>

                    <div class="footer-widget__social">
                        <ul class="social-icon-list">
                            <li class="social-icon-list__item">
                                <a href="#" target="_blank" class="social-icon-list__link flx-center"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="#" target="_blank" class="social-icon-list__link flx-center"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="#" target="_blank" class="social-icon-list__link flx-center"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="#" target="_blank" class="social-icon-list__link flx-center"><i class="fab fa-pinterest-p"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="#" target="_blank" class="social-icon-list__link flx-center"><i class="fab fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-sm-6 col-xs-6">
                <div class="footer-widget">
                    <h5 class="footer-widget__title text-white">Useful Link</h5>
                    <ul class="footer-lists">
                        <li class="footer-lists__item"><a href="{{ route('shop') }}" class="footer-lists__link">Product</a></li>
                        <li class="footer-lists__item"><a href="{{ route('customer.dashboard') }}" class="footer-lists__link">Profile</a></li>
                        <li class="footer-lists__item"><a href="{{ route('customer.dashboard') }}" class="footer-lists__link">Dashboard</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-1 d-xl-block d-none"></div>

            <div class="col-xl-3 col-sm-6 col-xs-6">
                <div class="footer-widget">
                    <h5 class="footer-widget__title text-white">Quick Links</h5>
                    <ul class="footer-lists">
                        <li class="footer-lists__item"><a href="{{ route('customer.dashboard') }}" class="footer-lists__link">Dashboard</a></li>
                        <li class="footer-lists__item"><a href="{{ route('customer.login') }}" class="footer-lists__link">Login</a></li>
                        <li class="footer-lists__item"><a href="{{ route('customer.register') }}" class="footer-lists__link">Register</a></li>
                        <li class="footer-lists__item"><a href="{{ route('blog') }}" class="footer-lists__link">Blog</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-xs-6">
                <div class="footer-widget">
                    <h5 class="footer-widget__title text-white">Categories</h5>
                    <ul class="footer-lists">
                        @forelse (GlobalCategories() ?? [] as $category)
                            <li class="footer-lists__item">
                                <a href="{{ route('product.by.category', $category->slug) }}" class="footer-lists__link">{{ $category->name }}</a>
                            </li>
                        @empty
                            <li class="footer-lists__item"><span class="footer-lists__link">No categories yet</span></li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>

    </div>

</footer>

<!-- bottom Footer -->
<div class="bottom-footer">
    <div class="container container-two">
        <div class="bottom-footer__inner flx-between gap-3">
            <p class="bottom-footer__text font-14">{{ GlobalSiteSettings()->site_copyright }}, All rights reserved.</p>
            <div class="footer-links">
                <a href="{{ route('terms.conditions') }}" class="footer-link font-14">Terms of service</a>
                <a href="{{ route('privacy.policy') }}" class="footer-link font-14">Privacy Policy</a>
            </div>
        </div>
    </div>
</div>
