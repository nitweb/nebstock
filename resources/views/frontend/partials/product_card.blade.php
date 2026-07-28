<article class="product__card">
    <div class="product__card--thumbnail">

        <a class="product__card--thumbnail__link display-block" href="{{ route('product.details', $item->slug) }}" title="{{ $item->name }}">
            <img class="product__card--thumbnail__img product__primary--img" src="{{ $item->cover_image ? asset('upload/product_covers/' . $item->cover_image) : asset('upload/no_image.jpg') }}" alt="{{ $item->name }}">
            <img class="product__card--thumbnail__img product__secondary--img" src="{{ $item->cover_image ? asset('upload/product_covers/' . $item->cover_image) : asset('upload/no_image.jpg') }}" alt="{{ $item->name }}">
        </a>

        {{-- Badge: side by side --}}
        @php
            $discPct = $item->discount_price ? round((1 - $item->discount_price / $item->price) * 100) : 0;
            $isOutOfStock = $item->stock_status === 'out_of_stock';
        @endphp

        @if (!$item->is_pre_order)
            <div style="position:absolute; top:10px; left:10px; display:flex; gap:5px; flex-wrap:wrap;">

                {{-- Stock Status Badge --}}
                @if ($isOutOfStock)
                    <span style="
                display:inline-block;
                font-size:10px;
                font-weight:700;
                color:#fff;
                background:#e74c3c;
                border-radius:4px;
                padding: 5px 8px 1PX;
                line-height:1.6;
            ">Out of Stock</span>
                @else
                    <span style="
                display:inline-block;
                font-size:10px;
                font-weight:700;
                color:#fff;
                background:#27ae60;
                border-radius:4px;
                padding: 5px 8px 1PX;
                line-height:1.6;
            ">In Stock</span>
                @endif

                {{-- Discount Badge --}}
                @if ($discPct > 0)
                    <span style="
                display:inline-block;
                font-size:10px;
                font-weight:700;
                color:#fff;
                background:#f39c12;
                border-radius:4px;
                padding: 5px 8px 1PX;
                line-height:1.6;
            ">{{ $discPct }}% OFF</span>
                @endif

            </div>
        @else
            {{-- Pre-order: Coming Soon badge --}}
            <span class="product__badge" style="background:#e67e22; width:8rem;">Coming Soon</span>
        @endif

        {{-- Action Buttons --}}
        <ul class="product__card--action">
            <li class="product__card--action__list">
                <a class="product__card--action__btn quick-view-btn" title="Quick View" data-product-id="{{ $item->id }}" href="javascript:void(0)">
                    <svg class="product__card--action__btn--svg" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.6952 14.4991L11.7663 10.5588C12.7765 9.4008 13.33 7.94381 13.33 6.42703C13.33 2.88322 10.34 0 6.66499 0C2.98997 0 0 2.88322 0 6.42703C0 9.97085 2.98997 12.8541 6.66499 12.8541C8.04464 12.8541 9.35938 12.4528 10.4834 11.6911L14.4422 15.6613C14.6076 15.827 14.8302 15.9184 15.0687 15.9184C15.2944 15.9184 15.5086 15.8354 15.6711 15.6845C16.0166 15.364 16.0276 14.8325 15.6952 14.4991ZM6.66499 1.67662C9.38141 1.67662 11.5913 3.8076 11.5913 6.42703C11.5913 9.04647 9.38141 11.1775 6.66499 11.1775C3.94857 11.1775 1.73869 9.04647 1.73869 6.42703C1.73869 3.8076 3.94857 1.67662 6.66499 1.67662Z" fill="currentColor" />
                    </svg>
                    <span class="visually-hidden">Quick View</span>
                </a>
            </li>
            <li class="product__card--action__list">
                <a class="product__card--action__btn wishlist-btn {{ in_array($item->id, $wishlistedIds ?? []) ? 'active' : '' }}" title="Wishlist" href="javascript:void(0)" data-product-id="{{ $item->id }}">
                    <svg class="product__card--action__btn--svg" width="18" height="18" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.5379 1.52734C11.9519 0.1875 9.51832 0.378906 8.01442
                     1.9375C6.48317 0.378906 4.04957 0.1875 2.46364 1.52734C0.412855
                     3.25 0.713636 6.06641 2.1902 7.57031L6.97536 12.4648C7.24879
                     12.7383 7.60426 12.9023 8.01442 12.9023C8.39723 12.9023 8.7527
                     12.7383 9.02614 12.4648L13.8386 7.57031C15.2879 6.06641 15.5886
                     3.25 13.5379 1.52734ZM12.8816 6.64062L8.09645 11.5352C8.04176
                     11.5898 7.98707 11.5898 7.90504 11.5352L3.11989 6.64062C2.10817
                     5.62891 1.91676 3.71484 3.31129 2.53906C4.3777 1.63672 6.01832
                     1.77344 7.05739 2.8125L8.01442 3.79688L8.97145 2.8125C9.98317
                     1.77344 11.6238 1.63672 12.6902 2.51172C14.0847 3.71484 13.8933
                     5.62891 12.8816 6.64062Z" fill="currentColor" />
                    </svg>
                    <span class="visually-hidden">Wishlist</span>
                </a>
            </li>
        </ul>

        {{-- Add to Cart / Pre-Order / Pre-Booking Button --}}
        <div class="product__add--to__card">
            @if ($item->is_pre_order)
                {{-- Pre-order product --}}
                <a class="product__card--btn" href="{{ route('product.details', $item->slug) }}" style="background:#e67e22; align-items:center; justify-content:center; gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16" style="margin-top:-2px;">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                    </svg>
                    Pre-Order
                </a>
            @elseif ($isOutOfStock)
                {{-- Out of stock: Pre-Booking button --}}
                <a class="product__card--btn" href="{{ route('product.details', $item->slug) }}" style="background:#e67e22; align-items:center; justify-content:center; gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16" style="margin-top:-2px;">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                    </svg>
                    Pre-Booking
                </a>
            @else
                {{-- Normal in stock product --}}
                <a class="product__card--btn add-to-cart-btn" href="javascript:void(0)" data-product-id="{{ $item->id }}" data-product-name="{{ $item->name }}">
                    Add to Cart
                    <svg width="17" height="15" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-top: -5px;">
                        <path d="M13.2371 4H11.5261L8.5027 0.460938C8.29176 0.226562 7.9402 0.203125 7.70582
                            0.390625C7.47145 0.601562 7.44801 0.953125 7.63551 1.1875L10.0496 4H3.46364L5.8777
                            1.1875C6.0652 0.953125 6.04176 0.601562 5.80739 0.390625C5.57301 0.203125 5.22145
                            0.226562 5.01051 0.460938L1.98707 4H0.299574C0.135511 4 0.0183239 4.14062 0.0183239
                            4.28125V4.84375C0.0183239 5.00781 0.135511 5.125 0.299574 5.125H0.721449L1.3777
                            9.78906C1.44801 10.3516 1.91676 10.75 2.47926 10.75H11.0339C11.5964 10.75 12.0652
                            10.3516 12.1355 9.78906L12.7918 5.125H13.2371C13.3777 5.125 13.5183 5.00781 13.5183
                            4.84375V4.28125C13.5183 4.14062 13.3777 4 13.2371 4ZM11.0339 9.625H2.47926L1.86989
                            5.125H11.6433L11.0339 9.625Z" fill="currentColor" />
                    </svg>
                </a>
            @endif
        </div>

    </div>

    <div class="product__card--content text-center">
        <h3 class="product__card--title">
            <a href="{{ route('product.details', $item->slug) }}" title="{{ $item->name }}">
                {{ Str::limit($item->name, 40) }}
            </a>
        </h3>

        @if ($item->authors->isNotEmpty())
            <p style="font-size:12px;color:#aaa;margin-bottom:4px;margin-top:-2px;">
                {{ $item->authors->pluck('name')->implode(', ') }}
            </p>
        @endif

        <div class="product__card--price">

            @if ($item->isAffiliate)
                {{-- Affiliate Product --}}
                @if ($item->affiliate_price)
                    <span class="current__price">
                        ${{ number_format($item->affiliate_price, 2) }}
                    </span>
                    <small class="text-muted" style="font-size:13px;">
                        on {{ $item->affiliate_platform }}
                    </small>
                @else
                    <span class="current__price" style="font-size:16px;color:#888;">
                        Price varies by platform
                    </span>
                @endif
            @else
                {{-- Normal / Pre-order Product --}}
                <span class="current__price">
                    ${{ number_format($item->selling_price, 2) }}
                </span>

                @if ($item->discount_price)
                    <span class="old__price">
                        ${{ number_format($item->price, 2) }}
                    </span>
                    @if ($discPct > 0)
                        <span class="price__badge">-{{ $discPct }}%</span>
                    @endif
                @endif

            @endif

        </div>
    </div>
</article>
