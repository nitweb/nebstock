<div class="offcanvas__filter--sidebar widget__area">
    <button type="button" class="offcanvas__filter--close" data-offcanvas>
        <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368" />
        </svg>
        <span class="offcanvas__filter--close__text">Close</span>
    </button>

    <div class="offcanvas__filter--sidebar__inner">

        {{-- Price Filter --}}
        <div class="single__widget price__filter widget__bg">
            <h2 class="widget__title h3">Filter By Price</h2>
            <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                <div class="price__filter--group">
                    <label class="price__filter--label">From ($)</label>
                    <div class="price__filter--input border-radius-5 d-flex align-items-center">
                        <span class="price__filter--currency">$</span>
                        <input class="price__filter--input__field border-0 filter-input" id="min_price" name="min_price" type="number" placeholder="0" min="0" value="{{ request('min_price') }}">
                    </div>
                </div>
                <div class="price__divider"><span>-</span></div>
                <div class="price__filter--group">
                    <label class="price__filter--label">To ($)</label>
                    <div class="price__filter--input border-radius-5 d-flex align-items-center">
                        <span class="price__filter--currency">$</span>
                        <input class="price__filter--input__field border-0 filter-input" id="max_price" name="max_price" type="number" placeholder="9999" min="0" value="{{ request('max_price') }}">
                    </div>
                </div>
            </div>
            <button class="primary__btn price__filter--btn w-100" id="applyPriceBtn">
                Filter Price
            </button>
        </div>

        {{-- Categories (recursive tree) --}}
        <div class="single__widget widget__bg">
            <h2 class="widget__title h3">Categories</h2>
            <ul class="widget__categories--menu" id="categoryFilterList">
                @include('frontend.pages.partials.category_filter_tree', [
                    'categories' => $categories,
                    'depth' => 0,
                ])
            </ul>
        </div>

        {{-- Top Selling --}}
        <div class="single__widget widget__bg">
            <h2 class="widget__title h3">Top Selling</h2>
            <div class="shop__sidebar--product">
                @foreach ($top_sell_product as $item)
                    <div class="small__product--card d-flex align-items-center gap-3 mb-3">
                        <div style="width:70px;height:70px;flex-shrink:0;overflow:hidden;border-radius:6px;">
                            <a href="{{ route('product.details', $item->slug) }}">
                                <img src="{{ $item->cover_image ? asset('upload/product_covers/' . $item->cover_image) : asset('upload/no_image.jpg') }}" alt="{{ $item->name }}" style="width:70px;height:70px;object-fit:cover;">
                            </a>
                        </div>
                        <div class="small__product--content">
                            <h3 class="small__product--card__title">
                                <a href="{{ route('product.details', $item->slug) }}">
                                    {{ Str::limit($item->name, 30) }}
                                </a>
                            </h3>
                            <div class="small__product--card__price mb_5">
                                <span class="current__price">${{ number_format($item->selling_price, 2) }}</span>
                                @if ($item->discount_price)
                                    <span class="old__price">${{ number_format($item->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
