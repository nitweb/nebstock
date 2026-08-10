<section class="featured-product padding-y-120 position-relative z-index-1">

    <img src="{{ asset('frontend/assets/images/gradients/featured-gradient.png') }}" alt="" class="bg--gradient white-version">
    <img src="{{ asset('frontend/assets/images/shapes/spider-net.png') }}" alt="" class="spider-net position-absolute top-0 end-0 z-index--1 white-version">
    <img src="{{ asset('frontend/assets/images/shapes/spider-net-white.png') }}" alt="" class="spider-net position-absolute top-0 end-0 z-index--1 dark-version">

    <img src="{{ asset('frontend/assets/images/shapes/element1.png') }}" alt="" class="element two">

    <div class="container container-two">

        <div class="row gy-4 flex-wrap-reverse align-items-center">

            <div class="col-xl-6">

                <div class="row gy-4 card-wrapper">

                    @forelse($featured_products as $product)
                        <div class="col-sm-6">
                            <div class="product-item box-shadow">
                                <div class="product-item__thumb d-flex">
                                    <a href="javascript:void(0)" class="link w-100">
                                        <img src="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('frontend/assets/images/thumbs/product-img9.png') }}" alt="{{ $product->name }}" class="cover-img">
                                    </a>
                                    @include('frontend.partials.wishlist_button', ['product' => $product])
                                </div>
                                <div class="product-item__content">
                                    <h6 class="product-item__title mb-3">
                                        <a href="javascript:void(0)" class="link">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-item__bottom">
                                        @include('frontend.partials.download_button', ['product' => $product])
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center w-100">No featured products yet.</p>
                    @endforelse

                </div>
            </div>

            <div class="col-xl-1 d-xl-block d-none"></div>

            <div class="col-xl-5">
                <div class="section-content">
                    <div class="section-heading style-left">
                        <h3 class="section-heading__title">Featured Products</h3>
                        <p class="section-heading__desc font-18 w-sm">Every month we pick some best products for you. This month's best web themes & templates have arrived, chosen by our content specialists.</p>
                    </div>
                    <a href="{{ route('shop') }}" class="btn btn-main btn-lg pill fw-300">
                        View All Items
                    </a>
                </div>
            </div>

        </div>

    </div>

</section>