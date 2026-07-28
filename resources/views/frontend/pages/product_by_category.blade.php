@extends('frontend.dashboard')
@section('frontend_title', $categoryInfo->name)
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">{{ $categoryInfo->name }}</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Shop Category</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shop Section --}}
    <div class="shop__section section--padding">

        <div class="container">

            <div class="row">

                {{-- ── SIDEBAR (desktop) ──────────────────────────────────────── --}}
                <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                    <div class="shop__sidebar--widget widget__area">

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
                </div>{{-- /sidebar --}}

                <div class="col-xl-9 col-lg-8">
                    <div class="shop__product--wrapper">

                        {{-- Header --}}
                        <div class="shop__header d-flex align-items-center justify-content-between mb-30 flex-wrap gap-2">
                            <p class="product__showing--count mb-0" id="showingCount">
                                Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
                                of {{ $products->total() }} results
                            </p>

                            <div class="d-flex align-items-center gap-3 flex-wrap">

                                {{-- Mobile filter toggle --}}
                                <button class="widget__filter--btn d-flex d-lg-none align-items-center" data-offcanvas>
                                    <svg class="widget__filter--btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" d="M368 128h80M64 128h240M368 384h80M64 384h240M208 256h240M64 256h80" />
                                        <circle cx="336" cy="128" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" />
                                        <circle cx="176" cy="256" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" />
                                        <circle cx="336" cy="384" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" />
                                    </svg>
                                    <span class="widget__filter--btn__text">Filter</span>
                                </button>

                                {{-- Sort --}}
                                <div class="product__view--mode__list product__short--by d-flex align-items-center">
                                    <label class="product__view--label me-2">Sort:</label>
                                    <div class="select shop__header--select">
                                        <select class="product__view--select filter-input" id="sort_select" name="sort">
                                            <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A → Z</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Loading overlay --}}
                        <div id="shopLoading" style="display:none;text-align:center;padding:60px 0;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading…</span>
                            </div>
                            <p class="mt-2 text-muted small">Loading products…</p>
                        </div>

                        {{-- Product Grid --}}
                        <div class="tab_content" id="shopContent">
                            <div id="product_grid" class="tab_pane active show">
                                <div class="product__section--inner">
                                    <div class="row mb--n30" id="productGrid">
                                        @include('frontend.pages.partials.shop_grid', compact('products'))
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pagination --}}
                        <div id="shopPagination">
                            @include('frontend.pages.partials.shop_pagination', compact('products'))
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    @include('frontend.layouts.offcanvas_sidebar')

@endsection
