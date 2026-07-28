@extends('frontend.dashboard')
@section('frontend_title', 'Shop')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image:url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Shop</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Shop</span>
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

                {{-- ── MAIN CONTENT ────────────────────────────────────────────── --}}
                <div class="col-xl-9 col-lg-8">
                    <div class="shop__product--wrapper">

                        {{-- ── Shop Header: Showing count + Sort ── --}}
                        <div class="shop__header d-flex align-items-center justify-content-between mb-0 flex-wrap gap-2">
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

                        {{-- ── Active Filter Tags — outside header, below it ── --}}
                        <div id="activeFiltersBar" class="active-filters-bar" style="display:none;">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="active-filters-label">Active Filters:</span>
                                <span id="activeFilterTags" class="d-flex flex-wrap gap-2"></span>
                                <a href="#" id="clearAllFilters" class="active-filter-clear">
                                    ✕ Clear All
                                </a>
                            </div>
                        </div>

                        {{-- Loading overlay --}}
                        <div id="shopLoading" style="display:none;text-align:center;padding:60px 0;">
                            <div class="spinner-border" role="status" style="color: var(--secondary-color);">
                                <span class="visually-hidden">Loading…</span>
                            </div>
                            <p class="mt-2 small" style="color: var(--foreground-sub-color);">Loading products…</p>
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
                </div>{{-- /main --}}

            </div>
        </div>
    </div>

    {{-- Offcanvas sidebar (mobile) --}}
    @include('frontend.layouts.offcanvas_sidebar')

    @push('scripts')
        <script>
            $(function() {

                // ── State ─────────────────────────────────────────────────────────────────
                const filters = {
                    min_price: '{{ request('min_price') }}',
                    max_price: '{{ request('max_price') }}',
                    category: '{{ request('category') }}',
                    author: '{{ request('author') }}',
                    type: '{{ request('type') }}',
                    sort: '{{ request('sort', 'latest') }}',
                    page: 1,
                };

                // ── Fetch products via AJAX ───────────────────────────────────────────────
                function fetchProducts(resetPage = true) {
                    if (resetPage) filters.page = 1;

                    const params = {};
                    Object.entries(filters).forEach(([k, v]) => {
                        if (v) params[k] = v;
                    });

                    const qs = new URLSearchParams(params).toString();
                    window.history.replaceState(null, '', '{{ route('shop') }}' + (qs ? '?' + qs : ''));

                    $('#shopLoading').show();
                    $('#productGrid, #shopPagination').css('opacity', '.4');

                    $.ajax({
                        url: '{{ route('shop') }}',
                        method: 'GET',
                        data: params,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(res) {
                            $('#productGrid').html(res.grid);
                            $('#shopPagination').html(res.pagination);

                            const from = res.from || 0;
                            const to = res.to || 0;
                            const total = res.total || 0;
                            $('#showingCount').text(
                                total > 0 ?
                                `Showing ${from}–${to} of ${total} results` :
                                'No products found'
                            );

                            updateActiveFilters();
                            $('#shopLoading').hide();
                            $('#productGrid, #shopPagination').css('opacity', '1');
                            $('html, body').animate({
                                scrollTop: $('#product_grid').offset().top - 100
                            }, 300);
                        },
                        error: function() {
                            $('#shopLoading').hide();
                            $('#productGrid, #shopPagination').css('opacity', '1');
                        }
                    });
                }

                // ── Active filter tags ────────────────────────────────────────────────────
                function updateActiveFilters() {
                    const tags = [];

                    if (filters.min_price || filters.max_price) {
                        const from = filters.min_price ? '$' + filters.min_price : '0';
                        const to = filters.max_price ? '$' + filters.max_price : '∞';
                        tags.push({
                            label: `Price: ${from} – ${to}`,
                            key: 'price'
                        });
                    }
                    if (filters.category) {
                        const name = $(`[data-cat-slug="${filters.category}"]`).first().text().trim() || filters.category;
                        tags.push({
                            label: `Category: ${name}`,
                            key: 'category'
                        });
                    }
                    if (filters.sort && filters.sort !== 'latest') {
                        const sortLabels = {
                            price_asc: 'Price ↑',
                            price_desc: 'Price ↓',
                            name_asc: 'Name A–Z'
                        };
                        tags.push({
                            label: `Sort: ${sortLabels[filters.sort] || filters.sort}`,
                            key: 'sort'
                        });
                    }

                    if (tags.length === 0) {
                        $('#activeFiltersBar').slideUp(200);
                        return;
                    }

                    const html = tags.map(t =>
                        `<span class="active-filter-tag" data-remove-key="${t.key}">
                            <span class="active-filter-tag__icon">◈</span>
                            ${t.label}
                            <span class="active-filter-tag__remove">✕</span>
                        </span>`
                    ).join('');

                    $('#activeFilterTags').html(html);
                    $('#activeFiltersBar').slideDown(200);
                }

                // ── Remove single filter tag ──────────────────────────────────────────────
                $(document).on('click', '.active-filter-tag', function() {
                    const key = $(this).data('remove-key');
                    if (key === 'price') {
                        filters.min_price = '';
                        filters.max_price = '';
                        $('#min_price, #min_price_mob').val('');
                        $('#max_price, #max_price_mob').val('');
                    } else if (key === 'sort') {
                        filters.sort = 'latest';
                        $('#sort_select, #sort_select_mob').val('latest');
                    } else {
                        filters[key] = '';
                        $('[data-cat-slug]').removeClass('active-cat-filter');
                    }
                    fetchProducts();
                });

                // ── Clear All ─────────────────────────────────────────────────────────────
                $('#clearAllFilters').on('click', function(e) {
                    e.preventDefault();
                    Object.keys(filters).forEach(k => filters[k] = k === 'sort' ? 'latest' : '');
                    filters.page = 1;
                    $('#min_price, #min_price_mob').val('');
                    $('#max_price, #max_price_mob').val('');
                    $('#sort_select, #sort_select_mob').val('latest');
                    $('[data-cat-slug]').removeClass('active-cat-filter');
                    fetchProducts();
                });

                // ── Price filter ──────────────────────────────────────────────────────────
                $('#applyPriceBtn, #applyPriceBtnMob').on('click', function() {
                    filters.min_price = $('#min_price').val() || $('#min_price_mob').val();
                    filters.max_price = $('#max_price').val() || $('#max_price_mob').val();
                    fetchProducts();
                });

                // ── Category click ────────────────────────────────────────────────────────
                $(document).on('click', '[data-cat-slug]', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const slug = $(this).data('cat-slug');
                    if (filters.category === slug) {
                        filters.category = '';
                        $('[data-cat-slug]').removeClass('active-cat-filter');
                    } else {
                        filters.category = slug;
                        $('[data-cat-slug]').removeClass('active-cat-filter');
                        $(this).addClass('active-cat-filter');
                    }
                    fetchProducts();
                });

                // ── Sort change ───────────────────────────────────────────────────────────
                $('#sort_select, #sort_select_mob').on('change', function() {
                    filters.sort = $(this).val();
                    fetchProducts();
                });

                // ── Pagination ────────────────────────────────────────────────────────────
                $(document).on('click', '.ajax-page', function(e) {
                    e.preventDefault();
                    filters.page = $(this).data('page');
                    fetchProducts(false);
                });

                // ── Init ──────────────────────────────────────────────────────────────────
                if (filters.category) {
                    $(`[data-cat-slug="${filters.category}"]`).addClass('active-cat-filter');
                }
                updateActiveFilters();

            });
        </script>

        <style>
            /* ── Active Filters Bar ─────────────────────────────────────────── */
            .active-filters-bar {
                display: flex;
                align-items: center;
                padding: 10px 16px;
                margin-top: 12px;
                margin-bottom: 20px;
                background: var(--bg-gray-color, #F5F1E8);
                border: 1px solid var(--border-color, #E8E2D5);
                border-left: 3px solid var(--secondary-color, #B8860B);
                border-radius: 6px;
            }

            .active-filters-label {
                font-size: 12px;
                font-weight: 700;
                color: var(--foreground-sub-color, #6B6B6B);
                text-transform: uppercase;
                letter-spacing: 0.06em;
                white-space: nowrap;
                margin-right: 4px;
                margin-top: 7px;
            }

            /* ── Individual Tag ──────────────────────────────────────────────── */
            .active-filter-tag {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 11px 1px 9px;
                background: var(--bg-highlight-color, #FDF8EE);
                border: 1px solid var(--secondary-color, #B8860B);
                color: var(--foreground-color, #1A1A1A);
                border-radius: 4px;
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.2s, color 0.2s, transform 0.15s;
                user-select: none;
                letter-spacing: 0.01em;
            }

            .active-filter-tag:hover {
                background: var(--secondary-color, #B8860B);
                color: #fff;
                transform: translateY(-1px);
            }

            .active-filter-tag__icon {
                font-size: 9px;
                color: var(--secondary-color, #B8860B);
                transition: color 0.2s;
            }

            .active-filter-tag:hover .active-filter-tag__icon {
                color: #fff;
            }

            .active-filter-tag__remove {
                font-size: 10px;
                opacity: 0.55;
                margin-left: 2px;
                line-height: 1;
                transition: opacity 0.2s;
            }

            .active-filter-tag:hover .active-filter-tag__remove {
                opacity: 1;
            }

            /* ── Clear All Button ────────────────────────────────────────────── */
            .active-filter-clear {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 4px 12px 1px;
                background: transparent;
                border: 1px solid #dc3545;
                color: #000 !important;
                border-radius: 4px;
                font-size: 12px;
                font-weight: 600;
                text-decoration: none !important;
                letter-spacing: 0.03em;
                transition: background 0.2s, transform 0.15s;
                white-space: nowrap;
            }

            .active-filter-clear:hover {
                background: #dc3545;
                color: #fff !important;
                transform: translateY(-1px);
            }

            /* ── Active category highlight ───────────────────────────────────── */
            [data-cat-slug].active-cat-filter .widget__categories--sub__menu--text {
                color: var(--secondary-color, #B8860B);
                font-weight: 700;
            }

            [data-cat-slug].active-cat-filter {
                background: rgba(184, 134, 11, 0.07);
                border-radius: 4px;
            }

            /* ── Child category indent ───────────────────────────────────────── */
            .cat-filter-child {
                padding-left: 16px;
            }

            .cat-filter-grand {
                padding-left: 32px;
            }

            /* ── Loading fade ────────────────────────────────────────────────── */
            #productGrid,
            #shopPagination {
                transition: opacity .25s;
            }
        </style>
    @endpush

@endsection
