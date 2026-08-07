@extends('frontend.dashboard')
@section('frontend_title', $categoryInfo->name)
@section('frontend_contents')

    {{-- Breadcrumb Section --}}
    <section class="breadcrumb border-bottom p-0 d-block section-bg position-relative z-index-1">
        <div class="breadcrumb-two">
            <img src="{{ asset('frontend/assets/images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">
            <div class="container container-two">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="breadcrumb-two-content text-center">

                            <ul class="breadcrumb-list flx-align gap-2 mb-2 justify-content-center">
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <a href="{{ route('index') }}" class="breadcrumb-list__link text-body hover-text-main">Home</a>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__icon font-10"><i class="fas fa-chevron-right"></i></span>
                                </li>
                                @foreach($categoryInfo->breadcrumb() as $crumb)
                                    <li class="breadcrumb-list__item font-14 text-body">
                                        @if($crumb->id === $categoryInfo->id)
                                            <span class="breadcrumb-list__text">{{ $crumb->name }}</span>
                                        @else
                                            <a href="{{ route('product.by.category', $crumb->slug) }}" class="breadcrumb-list__link text-body hover-text-main">{{ $crumb->name }}</a>
                                            <span class="breadcrumb-list__icon font-10 ms-2"><i class="fas fa-chevron-right"></i></span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <h3 class="breadcrumb-two-content__title mb-0 text-capitalize">{{ $categoryInfo->name }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Product Section --}}
    <section class="all-product padding-y-120">
        <div class="container container-two">
            <form id="shopFilterForm" method="GET" action="{{ route('product.by.category', $categoryInfo->slug) }}">
            <div class="row">
                <div class="col-lg-12">
                    <div class="filter-tab gap-3 flx-between">
                        <button type="button" class="filter-tab__button btn btn-outline-light pill d-flex align-items-center sidebar-btn">
                            <span class="icon icon-left"><img src="{{ asset('frontend/assets/images/icons/filter.svg') }}" alt=""></span>
                            <span class="font-18 fw-500">Filters</span>
                        </button>
                        <div class="list-grid d-flex align-items-center gap-2">
                            <button type="button" class="list-grid__button sidebar-btn text-body d-lg-none d-flex"><i class="las la-bars"></i></button>
                        </div>
                    </div>
                    <div class="filter-form pb-4">
                        <div class="row gy-3">
                            <div class="col-sm-4 col-xs-6">
                                <div class="flx-between gap-1">
                                    <label for="tag" class="form-label font-16">Search</label>
                                    <button type="button" class="text-body font-14 shop-clear-input" data-target="tag">Clear</button>
                                </div>
                                <div class="position-relative">
                                    <input type="text" name="q" value="{{ request('q') }}" class="common-input border-gray-five common-input--withLeftIcon" id="tag" placeholder="Search in {{ $categoryInfo->name }}...">
                                    <span class="input-icon input-icon--left"><img src="{{ asset('frontend/assets/images/icons/search-two.svg') }}" alt=""></span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="flx-between gap-1">
                                    <label for="minPrice" class="form-label font-16">Min Price</label>
                                    <button type="button" class="text-body font-14 shop-clear-input" data-target="minPrice">Clear</button>
                                </div>
                                <div class="position-relative">
                                    <input type="number" step="0.01" name="min_price" value="{{ request('min_price') }}" class="common-input border-gray-five" id="minPrice" placeholder="e.g. 5">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="flx-between gap-1">
                                    <label for="maxPrice" class="form-label font-16">Max Price</label>
                                    <button type="button" class="text-body font-14 shop-clear-input" data-target="maxPrice">Clear</button>
                                </div>
                                <div class="position-relative">
                                    <input type="number" step="0.01" name="max_price" value="{{ request('max_price') }}" class="common-input border-gray-five" id="maxPrice" placeholder="e.g. 50">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4">
                    <!-- ===================== Filter Sidebar Start ============================= -->
                    <div class="filter-sidebar">
                        <button type="button" class="filter-sidebar__close p-2 position-absolute end-0 top-0 z-index-1 text-body hover-text-main font-20 d-lg-none d-block"><i class="las la-times"></i></button>
                        <div class="filter-sidebar__item">
                            <button type="button" class="filter-sidebar__button font-16 text-capitalize fw-500">Categories</button>
                            <div class="filter-sidebar__content">
                                <ul class="filter-sidebar-list">
                                    <li class="filter-sidebar-list__item">
                                        <a href="{{ route('shop') }}" class="filter-sidebar-list__text">
                                            All Categories
                                        </a>
                                    </li>
                                    @foreach($categories as $cat)
                                        <li class="filter-sidebar-list__item">
                                            <a href="{{ route('product.by.category', $cat->slug) }}" class="filter-sidebar-list__text {{ $cat->id === $categoryInfo->id ? 'fw-700 text-main' : '' }}">
                                                {{ $cat->name }}
                                            </a>
                                        </li>
                                        @foreach($cat->recursiveChildren as $child)
                                            <li class="filter-sidebar-list__item ps-3">
                                                <a href="{{ route('product.by.category', $child->slug) }}" class="filter-sidebar-list__text {{ $child->id === $categoryInfo->id ? 'fw-700 text-main' : '' }}">
                                                    {{ $child->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- ===================== Filter Sidebar End ============================= -->
                </div>

                <div class="col-xl-9 col-lg-8">

                    <div class="shop-top-bar flx-between gap-2 flex-wrap mb-4">
                        <span class="text-body font-14" id="shopResultText">Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results</span>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-body font-14">Sort:</span>
                            <div class="position-relative select-has-icon">
                                <select id="sort" name="sort" class="common-input border-gray-five">
                                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="shopGridWrapper">
                        @include('frontend.pages.partials.shop_grid', ['products' => $products])
                    </div>

                    <div id="shopPaginationWrapper">
                        @include('frontend.pages.partials.shop_pagination', ['products' => $products])
                    </div>

                </div>

            </div>
            </form>

        </div>

    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('shopFilterForm');
        const gridWrapper = document.getElementById('shopGridWrapper');
        const paginationWrapper = document.getElementById('shopPaginationWrapper');
        const resultText = document.getElementById('shopResultText');

        function loadProducts(url, pushState = true) {
            gridWrapper.style.opacity = 0.5;
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    gridWrapper.innerHTML = data.grid;
                    paginationWrapper.innerHTML = data.pagination;
                    resultText.textContent = `Showing ${data.from}–${data.to} of ${data.total} results`;
                    gridWrapper.style.opacity = 1;
                    if (pushState) window.history.pushState({}, '', url);
                    bindPaginationLinks();
                })
                .catch(() => { gridWrapper.style.opacity = 1; });
        }

        function buildUrlFromForm() {
            const formData = new FormData(form);
            const params = new URLSearchParams();
            for (const [key, value] of formData.entries()) {
                if (value !== '') params.append(key, value);
            }
            return form.action + '?' + params.toString();
        }

        function bindPaginationLinks() {
            document.querySelectorAll('#shopPagination .page-link[href]').forEach(function (link) {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    loadProducts(this.getAttribute('href'));
                    window.scrollTo({ top: gridWrapper.offsetTop - 100, behavior: 'smooth' });
                });
            });
        }
        bindPaginationLinks();

        form.querySelectorAll('#sort').forEach(function (el) {
            el.addEventListener('change', function () {
                loadProducts(buildUrlFromForm());
            });
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            loadProducts(buildUrlFromForm());
        });

        document.querySelectorAll('.shop-clear-input').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const target = document.getElementById(this.dataset.target);
                if (target) target.value = '';
                loadProducts(buildUrlFromForm());
            });
        });
    });
    </script>

@endsection
