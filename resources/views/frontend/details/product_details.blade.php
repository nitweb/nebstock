@extends('frontend.dashboard')
@section('frontend_title', $product->name)
@section('frontend_content')

    <style>
        :root {
            --accent: #B8860B;
            --accent-dark: #7c5901;
            --text-dark: #1A1A1A;
            --text-mid: #555;
            --text-light: #888;
            --border: #e8e8e8;
            --bg-soft: #f8f8fb;
            --star: #f5a623;
            --green: #28a745;
            --radius: 8px;
        }

        .breadcrumb__section {
            position: relative;
            padding: 50px 0;
            background-size: cover;
            background-position: center;
        }

        .breadcrumb__overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .55);
        }

        .breadcrumb__content {
            position: relative;
            z-index: 1;
        }

        .breadcrumb__title {
            font-size: 28px;
            font-weight: 700;
        }

        .breadcrumb__content--menu {
            list-style: none;
            gap: 10px;
            padding: 0;
            margin: 0;
        }

        .breadcrumb__content--menu__items+.breadcrumb__content--menu__items::before {
            content: '›';
            margin-right: 10px;
            color: #ccc;
        }

        .product__details--section {
            padding: 60px 0;
        }

        .product__gallery--wrap {
            position: sticky;
            top: 20px;
        }

        .detail__product--preview {
            border-radius: var(--radius);
            overflow: hidden;
            background: var(--bg-soft);
            margin-bottom: 12px;
        }

        .detail__product--preview .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail__product--preview img {
            width: 100%;
            height: 420px;
            object-fit: contain;
            padding: 20px;
        }

        .detail__product--nav {
            padding: 0 30px;
            position: relative;
        }

        .detail__product--nav .swiper-slide {
            width: 80px !important;
            cursor: pointer;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid transparent;
            transition: border-color .2s, opacity .2s;
            opacity: .65;
        }

        .detail__product--nav .swiper-slide-thumb-active {
            border-color: var(--accent);
            opacity: 1;
        }

        .detail__product--nav img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            display: block;
        }

        .detail__product--nav .swiper-button-next,
        .detail__product--nav .swiper-button-prev {
            color: var(--text-dark);
            width: 26px;
            height: 26px;
        }

        .detail__product--nav .swiper-button-next::after,
        .detail__product--nav .swiper-button-prev::after {
            font-size: 14px;
            font-weight: 700;
        }

        .product__details--info {
            padding-left: 16px;
        }

        .product__title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.3;
            margin-bottom: 8px;
        }

        .product__author--line {
            color: var(--text-mid);
            font-size: 14px;
            margin-bottom: 12px;
        }

        .product__author--line a {
            color: var(--accent);
            text-decoration: none;
        }

        .product__author--line a:hover {
            text-decoration: underline;
        }

        .stock__badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 15px 1px;
            border-radius: 5px;
            margin-bottom: 14px;
        }

        .stock__badge.in {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .stock__badge.out {
            background: #ffebee;
            color: #c62828;
        }

        .price__row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .price__current {
            font-size: 32px;
            font-weight: 800;
            color: var(--accent);
            line-height: 1;
        }

        .price__original {
            font-size: 18px;
            color: var(--text-light);
            text-decoration: line-through;
        }

        .price__badge {
            background: var(--accent);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 10px 1px;
            border-radius: 8px;
            line-height: 14px;
        }

        .product__short--desc {
            font-size: 15px;
            color: var(--text-mid);
            line-height: 1.7;
            margin-bottom: 20px;
            border-left: 3px solid var(--accent);
            padding-left: 12px;
        }

        .info__divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 20px 0;
        }

        .qty__cart--row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .qty__box {
            display: flex;
            align-items: center;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            background: #fff;
        }

        .qty__box button {
            width: 36px;
            height: 44px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: var(--text-dark);
            transition: background .15s;
        }

        .qty__box button:hover {
            background: var(--bg-soft);
        }

        .qty__box input {
            width: 50px;
            height: 44px;
            border: none;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            -moz-appearance: textfield;
        }

        .qty__box input::-webkit-outer-spin-button,
        .qty__box input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .btn__cart {
            min-width: 170px;
            background: var(--text-dark);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            padding: 13px 20px 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: center;
            gap: 8px;
            transition: background .2s, transform .15s;
        }

        .btn__cart:hover {
            background: #2d2d4a;
            transform: translateY(-1px);
        }

        .btn__cart:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        .btn__sample {
            background: #fff;
            color: var(--text-dark);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 11px 18px 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: border-color .2s, color .2s;
            white-space: nowrap;
        }

        .btn__sample:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .btn__buynow {
            width: 235px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            padding: 13px 20px 6px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            justify-content: center;
            gap: 8px;
            transition: background .2s, transform .15s;
        }

        .btn__buynow:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
        }

        .btn__wishlist {
            width: 100%;
            background: #fff;
            color: var(--text-dark);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 11px 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: border-color .2s, color .2s;
        }

        .btn__wishlist:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .spec__table {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 20px;
            font-size: 13.5px;
        }

        .spec__table table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .spec__table td {
            padding: 9px 14px;
            border-bottom: 1px solid var(--border);
        }

        .spec__table td:first-child {
            font-weight: 600;
            color: var(--text-dark);
            background: var(--bg-soft);
            width: 42%;
        }

        .spec__table td:last-child {
            color: var(--text-mid);
        }

        .spec__table tr:last-child td {
            border-bottom: none;
        }

        .affiliate__banner {
            background: linear-gradient(135deg, #fffbf0 0%, #fff8e6 100%);
            border: 1.5px solid #f0d88a;
            border-radius: 12px;
            padding: 18px 20px 20px;
            margin-bottom: 20px;
        }

        .affiliate__banner--label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--accent-dark);
            margin-bottom: 4px;
        }

        .affiliate__banner--label svg {
            flex-shrink: 0;
        }

        .affiliate__banner--title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-mid);
            margin-bottom: 14px;
        }

        .platform__grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 10px;
        }

        .platform__card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            background: #fff;
            border: 1.5px solid #e8d89a;
            border-radius: 10px;
            padding: 14px 12px 12px;
            text-decoration: none;
            text-align: center;
            transition: all .25s;
            box-shadow: 0 1px 4px rgba(184, 134, 11, .07);
            overflow: hidden;
        }

        .platform__card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-dark));
            transform: scaleX(0);
            transition: transform .25s;
        }

        .platform__card:hover {
            border-color: var(--accent);
            box-shadow: 0 6px 20px rgba(184, 134, 11, .18);
            transform: translateY(-3px);
            color: var(--text-dark);
        }

        .platform__card:hover::before {
            transform: scaleX(1);
        }

        .platform__card--icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fff8e1, #ffeaa0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            flex-shrink: 0;
        }

        .platform__card--name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .platform__card--price {
            font-size: 15px;
            font-weight: 800;
            color: var(--accent);
            line-height: 1;
        }

        .platform__card--price small {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-light);
            display: block;
            margin-top: 1px;
        }

        .platform__card--cta {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--accent);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px 0;
            border-radius: 20px;
            transition: background .2s;
            white-space: nowrap;
        }

        .platform__card:hover .platform__card--cta {
            background: var(--accent-dark);
        }

        .affiliate__sample--row {
            margin-bottom: 20px;
        }

        .social__row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }

        .social__label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .social__icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-mid);
            transition: all .2s;
            text-decoration: none;
        }

        .social__icon:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .product__tabs--section {
            padding: 50px 0 60px;
            border-top: 1px solid var(--border);
        }

        .tab__nav {
            display: flex;
            gap: 0;
            border-bottom: 2px solid var(--border);
            margin-bottom: 32px;
            list-style: none;
            padding: 0;
        }

        .tab__nav li button {
            background: none;
            border: none;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-light);
            cursor: pointer;
            position: relative;
            transition: color .2s;
        }

        .tab__nav li button::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent);
            transform: scaleX(0);
            transition: transform .2s;
        }

        .tab__nav li button.active {
            color: var(--accent);
        }

        .tab__nav li button.active::after {
            transform: scaleX(1);
        }

        .tab__pane {
            display: none;
        }

        .tab__pane.active {
            display: block;
        }

        .tab__pane--content {
            font-size: 15px;
            line-height: 1.9;
            color: var(--text-mid);
            max-width: 820px;
        }

        .tab__pane--content p {
            margin-bottom: 14px;
        }

        .safe__checkout {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 16px;
            margin-bottom: 20px;
            background: var(--bg-soft);
        }

        .safe__checkout h6 {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-mid);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 8px;
        }

        .safe__checkout img {
            max-width: 100%;
            height: auto;
        }

        .out__of__stock--notice {
            background: #fff5f5;
            border: 1.5px solid #ffcccc;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
    </style>

    @php $isAffiliate = ($product->product_mode ?? 'selling') === 'affiliate'; @endphp
    @php $isOutOfStock = $product->stock_status === 'out_of_stock'; @endphp
    @php $isPreOrder = $product->is_pre_order; @endphp

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image:url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="breadcrumb__content text-center">
                <h1 class="breadcrumb__title text-white mb-3">{{ $product->name }}</h1>
                <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                    <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb__content--menu__items"><span class="text-white">Product Details</span></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Product Details --}}
    <section class="product__details--section">
        <div class="container">
            <div class="row g-5">

                {{-- LEFT: Gallery --}}
                <div class="col-lg-5 col-md-6">
                    <div class="product__gallery--wrap">
                        <div class="detail__product--preview swiper" id="detail-main-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="product__media--preview__items">
                                        <a class="glightbox" data-gallery="product-gallery" href="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('upload/no_image.jpg') }}">
                                            <img src="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('upload/no_image.jpg') }}" alt="{{ $product->name }}">
                                        </a>
                                    </div>
                                </div>
                                @foreach ($product->galleryImages as $media)
                                    <div class="swiper-slide">
                                        <div class="product__media--preview__items">
                                            <a class="glightbox" data-gallery="product-gallery" href="{{ asset('upload/product_gallery/' . $media->file_path) }}">
                                                <img src="{{ asset('upload/product_gallery/' . $media->file_path) }}" alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="detail__product--nav swiper" id="detail-thumb-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('upload/no_image.jpg') }}" alt="{{ $product->name }}">
                                </div>
                                @foreach ($product->galleryImages as $media)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('upload/product_gallery/' . $media->file_path) }}" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Product Info --}}
                <div class="col-lg-7 col-md-6">
                    <div class="product__details--info">

                        <h1 class="product__title">{{ $product->name }}</h1>

                        @if ($product->authors->isNotEmpty())
                            <p class="product__author--line">
                                by
                                @foreach ($product->authors as $author)
                                    <a href="{{ route('product.by.author', $author->slug) }}">{{ $author->name }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                        @endif

                        @if (!$isAffiliate && !$isPreOrder)
                            @if ($isOutOfStock)
                                <span class="stock__badge out">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" style="margin-top:-3px">
                                        <circle cx="6" cy="6" r="6" />
                                    </svg>
                                    Out of Stock
                                </span>
                            @else
                                <span class="stock__badge in">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" style="margin-top:-3px">
                                        <circle cx="6" cy="6" r="6" />
                                    </svg>
                                    In Stock
                                </span>
                            @endif
                        @endif

                        <div class="price__row">
                            @if ($isAffiliate)
                                @if ($product->affiliate_price)
                                    <span class="price__current">${{ number_format($product->affiliate_price, 2) }}</span>
                                    <small class="text-muted" style="font-size:13px;">on {{ $product->affiliate_platform }}</small>
                                @else
                                    <span class="price__current" style="font-size:18px;color:#888;">Price varies by platform</span>
                                @endif
                            @else
                                <span class="price__current">${{ number_format($product->selling_price, 2) }}</span>
                                @if ($product->discount_price)
                                    <span class="price__original">${{ number_format($product->price, 2) }}</span>
                                    @php $discPct = round((1 - $product->discount_price / $product->price) * 100); @endphp
                                    @if ($discPct > 0)
                                        <span class="price__badge">-{{ $discPct }}%</span>
                                    @endif
                                @endif
                            @endif
                        </div>

                        @if ($product->short_description)
                            <p class="product__short--desc">{{ $product->short_description }}</p>
                        @endif

                        @if ($product->specification)
                            @php $spec = $product->specification; @endphp
                            <div class="spec__table">
                                <table>
                                    @if ($spec->publisher)
                                        <tr>
                                            <td>Publisher</td>
                                            <td>{{ $spec->publisher }}</td>
                                        </tr>
                                    @endif
                                    @if ($spec->edition)
                                        <tr>
                                            <td>Edition</td>
                                            <td>{{ $spec->edition }}</td>
                                        </tr>
                                    @endif
                                    @if ($spec->number_of_pages)
                                        <tr>
                                            <td>Total Pages</td>
                                            <td>{{ $spec->number_of_pages }}</td>
                                        </tr>
                                    @endif
                                    @if ($spec->language)
                                        <tr>
                                            <td>Language</td>
                                            <td>{{ $spec->language }}</td>
                                        </tr>
                                    @endif
                                    @if ($spec->publication_year)
                                        <tr>
                                            <td>Publish Year</td>
                                            <td>{{ $spec->publication_year }}</td>
                                        </tr>
                                    @endif
                                    @if ($spec->country)
                                        <tr>
                                            <td>Country</td>
                                            <td>{{ $spec->country }}</td>
                                        </tr>
                                    @endif
                                    @if ($spec->isbn)
                                        <tr>
                                            <td>ISBN</td>
                                            <td>{{ $spec->isbn }}</td>
                                        </tr>
                                    @endif
                                    @if ($product->categories->isNotEmpty())
                                        <tr>
                                            <td>Category</td>
                                            <td>
                                                @foreach ($product->categories as $cat)
                                                    <a href="{{ route('product.by.category', $cat->slug) }}" style="color:var(--accent);text-decoration:none;">{{ $cat->name }}</a>{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        @endif

                        @if ($product->attributes && count($product->attributes) > 0)
                            <div class="extra__attrs--wrap" style="margin-bottom:20px;">
                                <button class="extra__attrs--toggle" onclick="toggleAttrs(this)" style="width:100%;display:flex;align-items:center;justify-content:space-between;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius);padding:11px 16px;font-size:14px;font-weight:600;color:var(--text-dark);cursor:pointer;transition:all .2s;">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16" style="margin-right:6px;margin-bottom:2px;color:var(--accent);">
                                            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z" />
                                        </svg>
                                        Additional Attributes
                                        <span style="font-size:12px;font-weight:400;color:var(--text-light);margin-left:6px;">({{ count($product->attributes) }} items)</span>
                                    </span>
                                    <svg class="attrs__chevron" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="transition:transform .25s;color:var(--text-light);">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </button>
                                <div class="extra__attrs--body" style="display:none;border:1px solid var(--border);border-top:none;border-radius:0 0 var(--radius) var(--radius);overflow:hidden;">
                                    <table style="width:100%;border-collapse:collapse;font-size:13px;">
                                        @foreach ($product->attributes as $attrKey => $attrVal)
                                            <tr>
                                                <td style="padding:8px 14px;font-weight:600;color:var(--text-dark);background:var(--bg-soft);width:42%;border-bottom:1px solid var(--border);">{{ ucwords(str_replace('_', ' ', $attrKey)) }}</td>
                                                <td style="padding:8px 14px;color:var(--text-mid);border-bottom:1px solid var(--border);">{{ $attrVal }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        @endif

                        <hr class="info__divider">

                        @if (!$isAffiliate)

                            @if ($isPreOrder)
                                <div style="background:linear-gradient(135deg,#fff8f0,#fff3e0);border:1.5px solid #f0a060;border-radius:10px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px;">
                                    <span style="font-size:28px;">🕐</span>
                                    <div>
                                        <div style="font-weight:700;color:#c0621a;font-size:15px;">Pre-Order Available</div>
                                        <div style="font-size:13px;color:#888;margin-top:2px;">{{ $product->pre_order_label }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($isOutOfStock && !$isPreOrder)
                                <div class="out__of__stock--notice">
                                    <span style="font-size:26px;">😔</span>
                                    <div>
                                        <div style="font-weight:700;color:#c0392b;font-size:15px;">Currently Out of Stock</div>
                                        <div style="font-size:13px;color:#888;margin-top:2px;">This item is temporarily unavailable. Pre-order now to secure yours!</div>
                                    </div>
                                </div>
                            @endif

                            <div class="qty__cart--row">
                                <div class="qty__box">
                                    <button type="button" class="detail__decrease">−</button>
                                    <input type="number" id="product-qty" value="1" min="1">
                                    <button type="button" class="detail__increase">+</button>
                                </div>

                                @if ($product->pdf_sample)
                                    <a class="btn__sample" href="{{ asset('upload/product_pdfs/' . $product->pdf_sample) }}">Read Sample</a>
                                @endif

                                @if ($isPreOrder || $isOutOfStock)
                                    <button class="btn__cart add-to-cart-btn" type="button" data-product-id="{{ $product->id }}" data-pre-order="1" style="background:#e67e22; min-width:200px;">
                                        🕐 Pre-Order Now
                                    </button>
                                @else
                                    <button class="btn__cart add-to-cart-btn" type="button" data-product-id="{{ $product->id }}">
                                        Add To Cart
                                    </button>
                                    <button class="btn__buynow" type="button" id="buy-now-btn" data-product-id="{{ $product->id }}">
                                        Buy It Now
                                    </button>
                                @endif
                            </div>

                            <button class="btn__wishlist wishlist-btn mb-3" type="button" data-product-id="{{ $product->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 13">
                                    <path d="M13.5379 1.52734C11.9519 0.1875 9.51832 0.378906 8.01442 1.9375C6.48317 0.378906 4.04957 0.1875 2.46364 1.52734C0.412855 3.25 0.713636 6.06641 2.1902 7.57031L6.97536 12.4648C7.24879 12.7383 7.60426 12.9023 8.01442 12.9023C8.39723 12.9023 8.7527 12.7383 9.02614 12.4648L13.8386 7.57031C15.2879 6.06641 15.5886 3.25 13.5379 1.52734Z" fill="currentColor" />
                                </svg>
                                Add to Wishlist
                            </button>

                            <hr class="info__divider">

                        @endif

                        @if ($isAffiliate)

                            @if ($product->pdf_sample)
                                <div class="affiliate__sample--row">
                                    <a class="btn__sample" href="{{ asset('upload/product_pdfs/' . $product->pdf_sample) }}" target="_blank" style="display:inline-flex;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-top:-5px;">
                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                        </svg>
                                        Read Sample
                                    </a>
                                </div>
                            @endif

                            <div class="affiliate__banner">
                                <div class="affiliate__banner--label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z" />
                                    </svg>
                                    Available On
                                </div>
                                <p class="affiliate__banner--title">Choose your preferred platform to purchase this book</p>
                                <div class="platform__grid">
                                    @if ($product->affiliate_url)
                                        <a class="platform__card" href="{{ $product->affiliate_url }}" target="_blank" rel="noopener">
                                            <div class="platform__card--icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z" />
                                                </svg>
                                            </div>
                                            <div class="platform__card--name">{{ $product->affiliate_platform ?: 'Buy Now' }}</div>
                                            @if ($product->affiliate_price)
                                                <div class="platform__card--price">${{ number_format($product->affiliate_price, 2) }}<small>on {{ $product->affiliate_platform ?: 'store' }}</small></div>
                                            @endif
                                            <span class="platform__card--cta">Buy Now <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" viewBox="0 0 16 16" style="margin-top:-5px;">
                                                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                                </svg></span>
                                        </a>
                                    @endif
                                    @foreach ($product->relatedPlatforms as $platform)
                                        <a class="platform__card" href="{{ $platform->platform_url }}" target="_blank" rel="noopener">
                                            <div class="platform__card--icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z" />
                                                </svg>
                                            </div>
                                            <div class="platform__card--name">{{ $platform->platform_name }}</div>
                                            @if ($platform->platform_price)
                                                <div class="platform__card--price">${{ number_format($platform->platform_price, 2) }}<small>on {{ $platform->platform_name }}</small></div>
                                            @endif
                                            <span class="platform__card--cta">Buy Now <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" viewBox="0 0 16 16" style="margin-top:-5px;">
                                                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                                </svg></span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        @endif

                        <div class="safe__checkout">
                            <h6>Guaranteed Safe Checkout</h6>
                            <img src="{{ asset('frontend/assets/img/other/safe-checkout.webp') }}" alt="Safe Checkout">
                        </div>

                        <div class="social__row">
                            <span class="social__label">Share:</span>
                            <a class="social__icon" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" title="Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" fill="currentColor" viewBox="0 0 8 16">
                                    <path d="M6.06.8H8V0H6.06C4.1 0 3.15.93 3.15 2.86v1.28H1.5V5.2h1.65V16h1.6V5.2h2l.25-2.06H4.75v-.97C4.75 1.2 5.12.8 6.06.8z" />
                                </svg>
                            </a>
                            <a class="social__icon" href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->name) }}" target="_blank" rel="noopener" title="Twitter / X">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                                </svg>
                            </a>
                            <a class="social__icon" href="https://wa.me/?text={{ urlencode($product->name . ' ' . request()->url()) }}" target="_blank" rel="noopener" title="WhatsApp">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Tabs --}}
    <section class="product__tabs--section">
        <div class="container">
            <ul class="tab__nav">
                <li><button class="active" data-tab="description">Description</button></li>
                @if ($product->specification)
                    <li><button data-tab="specifications">Specifications</button></li>
                @endif
            </ul>

            <div class="tab__pane active" id="tab-description">
                <div class="tab__pane--content">
                    @if ($product->long_description)
                        {!! $product->long_description !!}
                    @else
                        <p>No description available.</p>
                    @endif
                </div>
            </div>

            @if ($product->specification)
                @php $spec = $product->specification; @endphp
                <div class="tab__pane" id="tab-specifications">
                    <div class="tab__pane--content">
                        <div class="spec__table" style="max-width:600px;">
                            <table>
                                @foreach (['Publisher' => $spec->publisher, 'Edition' => $spec->edition, 'Total Pages' => $spec->number_of_pages, 'Language' => $spec->language, 'Publish Year' => $spec->publication_year, 'Country' => $spec->country, 'ISBN' => $spec->isbn] as $label => $value)
                                    @if ($value)
                                        <tr>
                                            <td>{{ $label }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if ($product->attributes && count($product->attributes) > 0)
                                    @foreach ($product->attributes as $attrKey => $attrVal)
                                        <tr>
                                            <td>{{ ucwords(str_replace('_', ' ', $attrKey)) }}</td>
                                            <td>{{ $attrVal }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Related Products --}}
    @if ($related_products->isNotEmpty())
        <section class="product__section section--padding pt-0">
            <div class="container">
                <div class="section__heading text-center mb-40">
                    <h2 class="section__heading--maintitle">You May Also Like</h2>
                </div>
                <div class="product__section--inner product__swiper--column4 padding swiper">
                    <div class="swiper-wrapper">
                        @foreach ($related_products as $item)
                            <div class="swiper-slide">@include('frontend.partials.product_card')</div>
                        @endforeach
                    </div>
                    <div class="swiper__nav--btn swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                    <div class="swiper__nav--btn swiper-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- PDF Sample Modal --}}
    <div id="pdfSampleModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.75);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:12px;width:90%;max-width:900px;height:88vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 25px 60px rgba(0,0,0,.4);">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #eee;flex-shrink:0;">
                <span style="font-weight:700;font-size:15px;color:#1a1a1a;">📖 Read Sample</span>
                <button id="closePdfModal" style="background:none;border:none;font-size:24px;cursor:pointer;color:#555;line-height:1;">&times;</button>
            </div>
            <iframe id="pdfFrame" src="" style="flex:1;border:none;width:100%;"></iframe>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const thumbSwiper = new Swiper('#detail-thumb-slider', {
                    spaceBetween: 8,
                    slidesPerView: 5,
                    freeMode: true,
                    watchSlidesProgress: true,
                    navigation: {
                        nextEl: '#detail-thumb-slider .swiper-button-next',
                        prevEl: '#detail-thumb-slider .swiper-button-prev',
                    },
                });

                new Swiper('#detail-main-slider', {
                    spaceBetween: 10,
                    loop: false,
                    thumbs: {
                        swiper: thumbSwiper
                    },
                });

                new Swiper('#related-slider', {
                    spaceBetween: 20,
                    slidesPerView: 2,
                    navigation: {
                        nextEl: '#related-slider .swiper-button-next',
                        prevEl: '#related-slider .swiper-button-prev',
                    },
                    breakpoints: {
                        576: {
                            slidesPerView: 2
                        },
                        768: {
                            slidesPerView: 3
                        },
                        1024: {
                            slidesPerView: 4
                        },
                    },
                });

                if (typeof GLightbox !== 'undefined') {
                    GLightbox({
                        selector: '.glightbox',
                        touchNavigation: true,
                        loop: true
                    });
                }

                document.querySelectorAll('.tab__nav button').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.tab__nav button').forEach(b => b.classList.remove('active'));
                        document.querySelectorAll('.tab__pane').forEach(p => p.classList.remove('active'));
                        this.classList.add('active');
                        const target = document.getElementById('tab-' + this.dataset.tab);
                        if (target) target.classList.add('active');
                    });
                });
            });

            function toggleAttrs(btn) {
                const body = btn.nextElementSibling;
                const chevron = btn.querySelector('.attrs__chevron');
                const isOpen = body.style.display !== 'none';
                body.style.display = isOpen ? 'none' : 'block';
                chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
                btn.style.borderRadius = isOpen ? 'var(--radius)' : 'var(--radius) var(--radius) 0 0';
                btn.style.borderBottom = isOpen ? '1px solid var(--border)' : 'none';
            }

            // ── Custom Toast ───────────────────────────────────────────
            function showToast(type, message) {
                const old = document.getElementById('custom-toast');
                if (old) old.remove();

                const bgColor = type === 'success' ? '#27ae60' : '#e74c3c';
                const title = type === 'success' ? 'Success' : 'Error';
                const icon = type === 'success' ?
                    `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke="white" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 12l3 3 5-5"/></svg>` :
                    `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke="white" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/></svg>`;

                const toast = document.createElement('div');
                toast.id = 'custom-toast';
                toast.innerHTML = `
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">${icon}</div>
                        <div>
                            <div style="font-weight:700;font-size:14px;color:#fff;margin-bottom:2px;">${title}</div>
                            <div style="font-size:13px;color:rgba(255,255,255,0.9);">${message}</div>
                        </div>
                    </div>`;

                Object.assign(toast.style, {
                    position: 'fixed',
                    bottom: '24px',
                    right: '24px',
                    background: bgColor,
                    borderRadius: '10px',
                    padding: '14px 20px',
                    boxShadow: '0 8px 24px rgba(0,0,0,0.18)',
                    zIndex: '99999',
                    minWidth: '260px',
                    maxWidth: '340px',
                    opacity: '0',
                    transform: 'translateY(16px)',
                    transition: 'opacity 0.3s ease, transform 0.3s ease',
                });

                document.body.appendChild(toast);
                requestAnimationFrame(() => {
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateY(0)';
                });
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(16px)';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            $(function() {

                // PDF Sample Modal
                const pdfModal = document.getElementById('pdfSampleModal');
                const pdfFrame = document.getElementById('pdfFrame');

                document.querySelectorAll('.btn__sample').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        pdfFrame.src = this.getAttribute('href') || this.dataset.pdf;
                        pdfModal.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    });
                });

                document.getElementById('closePdfModal').addEventListener('click', function() {
                    pdfModal.style.display = 'none';
                    pdfFrame.src = '';
                    document.body.style.overflow = '';
                });

                pdfModal.addEventListener('click', function(e) {
                    if (e.target === pdfModal) {
                        pdfModal.style.display = 'none';
                        pdfFrame.src = '';
                        document.body.style.overflow = '';
                    }
                });

                // Quantity
                $('.detail__increase').on('click', function() {
                    const $i = $('#product-qty');
                    $i.val(parseInt($i.val()) + 1);
                });
                $('.detail__decrease').on('click', function() {
                    const $i = $('#product-qty');
                    if (parseInt($i.val()) > 1) $i.val(parseInt($i.val()) - 1);
                });

                // Buy Now
                $('#buy-now-btn').on('click', function() {
                    const $btn = $(this);
                    const qty = parseInt($('#product-qty').val()) || 1;
                    $btn.prop('disabled', true).text('Processing…');
                    $.ajax({
                        url: '/cart/add',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: $btn.data('product-id'),
                            quantity: qty
                        },
                        success: function(res) {
                            if (res.success) {
                                $('#cart-count').text(res.cart_count);
                                window.location.href = '/checkout';
                            }
                        },
                        error: function() {
                            $btn.prop('disabled', false).text('Buy It Now');
                            showToast('error', 'Failed to add product to cart');
                        }
                    });
                });

                // Add to Cart / Pre-Order — off() দিয়ে duplicate listener বন্ধ করো
                $(document).off('click', '.add-to-cart-btn').on('click', '.add-to-cart-btn', function() {
                    const $btn = $(this);
                    const prodId = $btn.data('product-id');
                    const qty = parseInt($('#product-qty').val()) || 1;
                    const isPreOrder = $btn.data('pre-order') ? 1 : 0;

                    $btn.prop('disabled', true);

                    $.ajax({
                        url: '/cart/add',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: prodId,
                            quantity: qty,
                            is_pre_order: isPreOrder,
                        },
                        success: function(res) {
                            if (res.success) {
                                $('#cart-count').text(res.cart_count);
                                showToast('success', res.message);
                            }
                        },
                        error: function(xhr) {
                            showToast('error', xhr.responseJSON?.message ?? 'Failed to add product to cart');
                        },
                        complete: function() {
                            $btn.prop('disabled', false);
                        }
                    });
                });

            });
        </script>
    @endpush

@endsection
