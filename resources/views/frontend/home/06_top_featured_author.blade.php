<section class="top-author padding-y-120 section-bg position-relative z-index-1">

    <img src="{{ asset('frontend/assets/images/gradients/featured-gradient.png') }}" alt="" class="bg--gradient white-version">
    <img src="{{ asset('frontend/assets/images/shapes/spider-net.png') }}" alt="" class="spider-net position-absolute top-0 start-0 z-index--1 white-version">
    <img src="{{ asset('frontend/assets/images/shapes/spider-net-white2.png') }}" alt="" class="spider-net position-absolute top-0 start-0 z-index--1 dark-version">
    <img src="{{ asset('frontend/assets/images/shapes/pattern-curve-three.png') }}" alt="" class="position-absolute top-0 end-0 z-index--1">

    <img src="{{ asset('frontend/assets/images/shapes/element1.png') }}" alt="" class="element two">

    <div class="container container-two">

        <div class="row gy-4 align-items-center">

            <div class="col-xl-5">
                <div class="section-content">
                    <div class="section-heading style-left">
                        <h3 class="section-heading__title">Top Featured Author</h3>
                        <p class="section-heading__desc font-18 w-sm">Every month we pick some best products for you. This month's best web themes & templates have arrived, chosen by our content specialists.</p>
                    </div>
                    <div class="author-info d-flex align-items-center gap-3">
                        <div class="author-info__thumb">
                            <img src="{{ $top_author && $top_author->image ? asset($top_author->image) : asset('frontend/assets/images/thumbs/author-img.png') }}" alt="{{ $top_author->name ?? 'Author' }}">
                        </div>
                        <div class="author-info__content">
                            <h4 class="author-info__name mb-1">{{ $top_author->name ?? 'No Author Yet' }}</h4>
                            <span class="author-info__text">Member Since {{ $top_author?->created_at?->format('Y') ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="flx-align gap-2 mt-48">
                        <a href="{{ $top_author ? route('product.by.author', $top_author->slug) : 'javascript:void(0)' }}" class="btn btn-main btn-lg pill fw-300"> View Profile </a>
                        <button type="button" class="follow-btn btn btn-outline-light btn-lg pill">Follow</button>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">

                <div class="circle-content position-relative">

                    <div class="circle static-circle">
                        <div class="circle__badge">
                            <img src="{{ asset('frontend/assets/images/icons/featured-badge.png') }}" alt="">
                        </div>
                        <div class="circle__text">
                            <p>
                                {{ $top_author->name ?? 'Our' }} Top Featured Author
                            </p>
                        </div>
                    </div>

                    <div class="row gy-4 card-wrapper">

                        @forelse($featured_products->take(4) as $product)
                            <div class="col-sm-6">
                                <div class="product-item box-shadow">
                                    <div class="product-item__thumb d-flex">
                                        <a href="javascript:void(0)" class="link w-100">
                                            <img src="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('frontend/assets/images/thumbs/product-img9.png') }}" alt="{{ $product->name }}" class="cover-img">
                                        </a>
                                        <button type="button" class="product-item__wishlist"><i class="fas fa-heart"></i></button>
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
                            <p class="text-center w-100">No products yet.</p>
                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
