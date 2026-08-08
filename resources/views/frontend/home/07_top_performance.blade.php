<section class="top-performance overflow-hidden padding-y-120 position-relative z-index-1">
    <img src="{{ asset('frontend/assets/images/shapes/spider-net.png') }}" alt="" class="spider-net position-absolute top-0 end-0 z-index--1 white-version">
    <img src="{{ asset('frontend/assets/images/shapes/spider-net-white.png') }}" alt="" class="spider-net position-absolute top-0 end-0 z-index--1 dark-version">
    <img src="{{ asset('frontend/assets/images/shapes/pattern-curve-four.png') }}" alt="" class="position-absolute top-0 start-0 z-index--1">

    <div class="container container-two">
        <div class="row gy-4 align-items-center flex-wrap-reverse">
            <div class="col-lg-7 pe-lg-5">
                <div class="position-relative">
                    <div class="circle style-two static-circle">
                        <div class="circle__badge">
                            <img src="{{ asset('frontend/assets/images/icons/featured-badge.png') }}" alt="">
                        </div>
                        <div class="circle__desc circle__text">
                            <p>
                                Our Top Performance
                            </p>
                        </div>
                    </div>
                    <div class="performance-content">
                        <div class="performance-content__item">
                            <span class="performance-content__text font-18">Email Subscription</span>
                            <h4 class="performance-content__count">{{ number_format($total_subscribers ?? 0) }}+</h4>
                        </div>
                        <div class="performance-content__item">
                            <span class="performance-content__text font-18"> Total Products</span>
                            <h4 class="performance-content__count">{{ number_format($total_products ?? 0) }}+</h4>
                        </div>
                        <div class="performance-content__item">
                            <span class="performance-content__text font-18"> Total Download</span>
                            <h4 class="performance-content__count">{{ number_format($total_downloads ?? 0) }}+</h4>
                        </div>
                        <div class="performance-content__item">
                            <span class="performance-content__text font-18"> Total Categories</span>
                            <h4 class="performance-content__count">{{ number_format($categories->count() ?? 0) }}+</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="section-content">
                    <div class="section-heading style-left">
                        <h3 class="section-heading__title">Top Performance</h3>
                        <p class="section-heading__desc font-18 w-sm">Every month we pick some best products for you. This month's best web themes & templates have arrived, chosen by our content specialists.</p>
                    </div>
                    <a href="{{ route('shop') }}" class="btn btn-main btn-lg pill fw-300"> Get Started </a>
                </div>
            </div>
        </div>
    </div>
</section>
