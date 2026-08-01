<section class="selling-product padding-y-120 position-relative z-index-1 overflow-hidden">

    <img src="{{ asset('frontend/assets/images/gradients/selling-gradient.png') }}" alt="" class="bg--gradient">

    <img src="{{ asset('frontend/assets/images/shapes/element2.png') }}" alt="" class="element one">
    <img src="{{ asset('frontend/assets/images/shapes/element1.png') }}" alt="" class="element two">

    <img src="{{ asset('frontend/assets/images/shapes/curve-pattern1.png') }}" alt="" class="position-absolute start-0 top-0 z-index--1">
    <img src="{{ asset('frontend/assets/images/shapes/curve-pattern2.png') }}" alt="" class="position-absolute end-0 top-0 z-index--1">

    <div class="container container-two">

        <div class="section-heading style-left style-white flx-between max-w-unset gap-4">
            <div>
                <h3 class="section-heading__title">Weekly Best selling Products</h3>
                <p class="section-heading__desc font-18">Every month we pick some best products for you. This month's best web themes &amp; templates have arrived, chosen by our content specialists.</p>
            </div>
            <a href="{{ route('shop') }}" class="btn btn-main btn-lg pill fw-300">
                View All Items
            </a>
        </div>

        <div class="selling-product-slider">

            @forelse($latest_products as $product)
                <div class="product-item shadow-sm overlay-none">
                    <div class="product-item__thumb d-flex max-h-unset">
                        <a href="javascript:void(0)" class="link w-100">
                            <img src="{{ $product->cover_image ? asset($product->cover_image) : asset('frontend/assets/images/thumbs/product-img12.png') }}" alt="{{ $product->name }}" class="cover-img">
                        </a>
                    </div>
                    <div class="product-item__content">
                        <h6 class="product-item__title">
                            <a href="javascript:void(0)" class="link">{{ $product->name }}</a>
                        </h6>
                        <div class="product-item__info flx-between gap-2">
                            <span class="product-item__author">
                                by
                                <a href="javascript:void(0)" class="link hover-text-decoration-underline"> {{ $product->primary_author_name ?: 'Unknown' }}</a>
                            </span>
                            <div class="flx-align gap-2">
                                <h6 class="product-item__price mb-0">${{ number_format($product->selling_price, 2) }}</h6>
                                @if($product->discount_price)
                                    <span class="product-item__prevPrice text-decoration-line-through">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="product-item__bottom flx-between gap-2">
                            <div>
                                <span class="product-item__sales font-16 mb-2">{{ $product->acceptedReviews->count() }} Reviews</span>
                                <ul class="star-rating gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <li class="star-rating__item font-16"><i class="fas fa-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="flx-align gap-2">
                                <a href="javascript:void(0)" class="btn btn-outline-light download-icon btn-icon btn-icon--sm pill">
                                    <span class="icon">
                                        <img src="{{ asset('frontend/assets/images/icons/download.svg') }}" alt="" class="white-version">
                                        <img src="{{ asset('frontend/assets/images/icons/download-white.svg') }}" alt="" class="dark-version">
                                    </span>
                                </a>
                                @include('frontend.partials.download_button', ['product' => $product])
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center w-100">No products available yet.</p>
            @endforelse

        </div>

    </div>

</section>
