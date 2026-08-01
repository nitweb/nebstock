<section class="arrival-product padding-y-120 section-bg position-relative z-index-1">

    <img src="{{ asset('frontend/assets/images/gradients/product-gradient.png') }}" alt="" class="bg--gradient white-version">

    <img src="{{ asset('frontend/assets/images/shapes/element2.png') }}" alt="" class="element one">

    <div class="container container-two">

        <div class="section-heading">
            <h3 class="section-heading__title">New Arrival Products</h3>
        </div>

        <ul class="nav common-tab justify-content-center nav-pills mb-48" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All Item</button>
            </li>
            @foreach($categories as $category)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-cat{{ $category->id }}-tab" data-bs-toggle="pill" data-bs-target="#pills-cat{{ $category->id }}" type="button" role="tab" aria-controls="pills-cat{{ $category->id }}" aria-selected="false">{{ $category->name }}</button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab" tabindex="0">
                <div class="row gy-4">
                    @forelse($latest_products as $product)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="product-item">
                                <div class="product-item__thumb d-flex">
                                    <a href="{{ route('product.details', $product->slug) }}" class="link w-100">
                                        <img src="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('frontend/assets/images/thumbs/product-img1.png') }}" alt="{{ $product->name }}" class="cover-img">
                                    </a>
                                    <button type="button" class="product-item__wishlist"><i class="fas fa-heart"></i></button>
                                </div>
                                <div class="product-item__content">
                                    <h6 class="product-item__title">
                                        <a href="{{ route('product.details', $product->slug) }}" class="link">{{ $product->name }}</a>
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
                                            <span class="product-item__sales font-14 mb-2">{{ $product->acceptedReviews->count() }} Reviews</span>
                                            <div class="d-flex align-items-center gap-1">
                                                <ul class="star-rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                    @endfor
                                                </ul>
                                            </div>
                                        </div>
                                        <a href="{{ route('product.details', $product->slug) }}" class="btn btn-outline-light btn-sm pill">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center w-100">No products available yet.</p>
                    @endforelse
                </div>
            </div>

            @foreach($categories as $category)
                <div class="tab-pane fade" id="pills-cat{{ $category->id }}" role="tabpanel" aria-labelledby="pills-cat{{ $category->id }}-tab" tabindex="0">
                    <div class="row gy-4">
                        @forelse($category->products as $product)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="product-item__thumb d-flex">
                                        <a href="{{ route('product.details', $product->slug) }}" class="link w-100">
                                            <img src="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('frontend/assets/images/thumbs/product-img1.png') }}" alt="{{ $product->name }}" class="cover-img">
                                        </a>
                                        <button type="button" class="product-item__wishlist"><i class="fas fa-heart"></i></button>
                                    </div>
                                    <div class="product-item__content">
                                        <h6 class="product-item__title">
                                            <a href="{{ route('product.details', $product->slug) }}" class="link">{{ $product->name }}</a>
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
                                                <span class="product-item__sales font-14 mb-2">{{ $product->acceptedReviews->count() }} Reviews</span>
                                                <div class="d-flex align-items-center gap-1">
                                                    <ul class="star-rating">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                            <a href="{{ route('product.details', $product->slug) }}" class="btn btn-outline-light btn-sm pill">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center w-100">No products in this category yet.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach

        </div>

        <div class="text-center mt-64">
            <a href="{{ route('shop') }}" class="btn btn-main btn-lg pill fw-300">
                View All Products
            </a>
        </div>

    </div>

</section>
