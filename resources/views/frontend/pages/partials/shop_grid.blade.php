<div class="row gy-4 list-grid-wrapper" id="shopGrid">
    @forelse($products as $product)
        <div class="col-xl-4 col-sm-6">
            <div class="product-item section-bg">
                <div class="product-item__thumb d-flex">
                    <a href="javascript:void(0)" class="link w-100">
                        <img src="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('frontend/assets/images/thumbs/product-img1.png') }}" alt="{{ $product->name }}" class="cover-img">
                    </a>
                    <button type="button" class="product-item__wishlist"><i class="fas fa-heart"></i></button>
                </div>
                <div class="product-item__content">
                    <h6 class="product-item__title">
                        <a href="javascript:void(0)" class="link">{{ $product->name }}</a>
                    </h6>
                    <div class="product-item__info flx-between gap-2">
                        @if($product->authors->count())
                            <span class="product-item__author">
                                by <a href="{{ route('product.by.author', $product->authors->first()->slug) }}" class="link hover-text-decoration-underline"> {{ $product->authors->first()->name }}</a>
                            </span>
                        @else
                            <span></span>
                        @endif
                        @if($product->categories->count())
                            <a href="{{ route('product.by.category', $product->categories->first()->slug) }}" class="badge bg-light text-dark font-12">{{ $product->categories->first()->name }}</a>
                        @endif
                    </div>
                    <div class="product-item__bottom flx-between gap-2">
                        <span class="product-item__sales font-14 mb-0">{{ $product->product_type ? ucfirst($product->product_type) : '' }}</span>
                        @include('frontend.partials.download_button', ['product' => $product])
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-center py-5">No products found matching your filters.</p>
        </div>
    @endforelse
</div>
