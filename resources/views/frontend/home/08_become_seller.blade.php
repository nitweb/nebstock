<section class="seller padding-y-120">

    <div class="container container-two">

        <div class="row gy-4">

            <div class="col-lg-6">
                <div class="seller-item position-relative z-index-1">
                    <img src="{{ asset('frontend/assets/images/shapes/seller-bg.png') }}" class="position-absolute
                    start-0 top-0 z-index--1" alt="">
                    <h3 class="seller-item__title">Earn 75% of the ItemD Price</h3>
                    <p class="seller-item__desc fw-500 text-heading">Sellers receive 75% of the Itemp Price for items Dsold exclusively and 50% for items sold non-exclusively. See detailed informationabout the fee structure on Market.</p>
                    <a href="{{ route('customer.register') }}" class="btn btn-static-outline-black btn-xl pill fw-600">Become a Seller</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="seller-item bg-two position-relative z-index-1">
                    <img src="{{ asset('frontend/assets/images/shapes/seller-bg-two.png') }}" class="position-absolute
                    start-0 top-0 z-index--1" alt="">
                    <h3 class="seller-item__title">Earn until 40% commission</h3>
                    <p class="seller-item__desc fw-500 text-heading">Our Market is the world’s largest creative market place, selling millions of digital assets every year. With 30% affiliate commission, earning money has never been easier!</p>
                    <a href="{{ route('customer.register') }}" class="btn btn-static-outline-black btn-xl pill fw-600">Become an Affiliate</a>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="support position-relative z-index-1">
                    <img src="{{ asset('frontend/assets/images/shapes/spider-net-sm.png') }}" alt="" class="spider-net position-absolute top-0 end-0 z-index--1">
                    <img src="{{ asset('frontend/assets/images/shapes/arrow-shape.png') }}" alt="" class="arrow-shape">
                    <div class="row align-items-center">
                        <div class="col-lg-1 d-lg-block d-none"></div>
                        <div class="col-lg-3 col-md-4 d-md-block d-none">
                            <div class="support-thumb text-center">
                                <img src="{{ asset('frontend/assets/images/thumbs/support-img.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-3 d-lg-block d-none"></div>
                        <div class="col-lg-5 col-md-8">
                            <div class="support-content">
                                <h3 class="support-content__title mb-3">Support 24/7</h3>
                                <p class="support-content__desc">Wanna talk? Send us a message</p>
                                <a href="mailto:{{ GlobalSiteSettings()->site_email ?? 'infomail@office.com' }}" class="btn btn-static-black btn-lg fw-300 pill">{{ GlobalSiteSettings()->site_email ?? 'infomail@office.com' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>
