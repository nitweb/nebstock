@extends('frontend.dashboard')
@section('frontend_title', 'Wishlist')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Wishlist</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Wishlist</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wishlist Section --}}
    <section class="cart__section section--padding">
        <div class="container">
            <div class="cart__section--inner">

                {{-- Guest Notice --}}
                @guest('user')
                    <div style="background:#f0f7ff;border:1.5px solid #bfdbfe;border-radius:10px; padding:12px 18px 5px;margin-bottom:20px;font-size:13px;color:#1e40af; display:flex;gap:10px;align-items:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="flex-shrink:0; margin-top: -3px;">
                            <circle cx="12" cy="12" r="10" stroke="#3b82f6" stroke-width="1.8" />
                            <path d="M12 8v4M12 16h.01" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <span>
                            Your wishlist is saved for this session.
                            <a href="{{ route('customer.login') }}" style="color:#2563eb;font-weight:600;text-decoration:underline;">Log in</a>
                            to save it permanently to your account.
                        </span>
                    </div>
                @endguest

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-30">
                    <h2 class="cart__title mb-0">My Wishlist</h2>
                    @if ($wishlists->isNotEmpty())
                        <button id="clear-all-btn" style="font-size:13px; padding:7px 18px; border-radius:6px;
                                   background:#fff1f1; color:#c0392b; border:1px solid #f5c6c6;
                                   cursor:pointer; font-weight:500;">
                            Clear All
                        </button>
                    @endif
                </div>

                @if ($wishlists->isEmpty())
                    <div class="text-center py-5" id="empty-wishlist">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity:.25;margin-bottom:16px;">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p style="color:#888;font-size:15px;">Your wishlist is empty.</p>
                        <a href="{{ route('shop') }}" style="display:inline-block;margin-top:12px;padding:9px 24px;
                                  background:#b8860b;color:#fff;border-radius:6px;font-size:14px;
                                  text-decoration:none;">
                            Continue Shopping
                        </a>
                    </div>
                @else
                    <div class="cart__table" id="wishlist-table-wrap">
                        <table class="cart__table--inner" style="width:100%;border-collapse:collapse;">
                            <thead class="cart__table--header">
                                <tr class="cart__table--header__items">
                                    <th class="cart__table--header__list">Product</th>
                                    <th class="cart__table--header__list text-center">Price</th>
                                    <th class="cart__table--header__list text-center">Stock Status</th>
                                    <th class="cart__table--header__list text-right">Add To Cart</th>
                                </tr>
                            </thead>
                            <tbody class="cart__table--body" id="wishlist-tbody">
                                @foreach ($wishlists as $wishlist)
                                    @php $product = $wishlist->product; @endphp
                                    <tr class="cart__table--body__items wishlist-item-row" id="wishlist-row-{{ $wishlist->id }}" data-wishlist-id="{{ $wishlist->id }}">

                                        {{-- Product Column --}}
                                        <td class="cart__table--body__list">
                                            <div class="cart__product d-flex align-items-center">

                                                {{-- AJAX Remove Button --}}
                                                <button class="cart__remove--btn wishlist-remove-btn" type="button" data-id="{{ $wishlist->id }}" data-product-id="{{ $product->id }}" aria-label="Remove from wishlist" title="Remove">
                                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px">
                                                        <path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312
                                                                                     L 10.585938 12 L 3.2929688 19.292969
                                                                                     L 4.7070312 20.707031 L 12 13.414062
                                                                                     L 19.292969 20.707031 L 20.707031 19.292969
                                                                                     L 13.414062 12 L 20.707031 4.7070312
                                                                                     L 19.292969 3.2929688 L 12 10.585938
                                                                                     L 4.7070312 3.2929688 z" />
                                                    </svg>
                                                </button>

                                                {{-- Product Image --}}
                                                <div class="cart__thumbnail">
                                                    <a href="{{ route('product.details', $product->slug) }}">
                                                        <img class="border-radius-5" src="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('upload/no_image.jpg') }}" alt="{{ $product->name }}" style="width:70px;height:70px;object-fit:cover;">
                                                    </a>
                                                </div>

                                                {{-- Product Info --}}
                                                <div class="cart__content">
                                                    <h3 class="cart__content--title h4">
                                                        <a href="{{ route('product.details', $product->slug) }}">
                                                            {{ $product->name }}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Price --}}
                                        <td class="cart__table--body__list text-center">
                                            <span class="cart__price">
                                                ${{ number_format($product->selling_price, 2) }}
                                            </span>
                                        </td>

                                        {{-- Stock Status --}}
                                        <td class="cart__table--body__list text-center">
                                            @if ($product->stock_status === 'in_stock')
                                                <span style="display:inline-block;font-size:12px;padding:4px 12px 1px;
                                                             border-radius:5px;background:#f0faf4;color:#27ae60;
                                                             border:1px solid #b7e4c7;font-weight:500;">
                                                    In Stock
                                                </span>
                                            @else
                                                <span style="display:inline-block;font-size:12px;padding:4px 12px 1px;
                                                             border-radius:5px;background:#fff1f1;color:#c0392b;
                                                             border:1px solid #f5c6c6;font-weight:500;">
                                                    Out of Stock
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Add to Cart --}}
                                        <td class="cart__table--body__list text-right" style="width: 200px;">
                                            @if ($product->stock_status === 'in_stock')
                                                <button class="wishlist__cart--btn primary__btn add-to-cart-btn" data-product-id="{{ $product->id }}" data-pre-order="0">
                                                    Add To Cart
                                                </button>
                                            @elseif ($product->is_pre_order)
                                                <button class="wishlist__cart--btn primary__btn add-to-cart-btn" data-product-id="{{ $product->id }}" data-pre-order="1" style="background:#e67e22;border-color:#e67e22;">
                                                    Pre-Order
                                                </button>
                                            @else
                                                <button class="wishlist__cart--btn primary__btn add-to-cart-btn" data-product-id="{{ $product->id }}" data-pre-order="1" style="background:#e67e22;border-color:#e67e22;">
                                                    Pre-Order
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Footer --}}
                        <div class="continue__shopping d-flex justify-content-start mt-3">
                            <a class="continue__shopping--link" href="{{ url('/') }}">
                                ← Continue Shopping
                            </a>
                        </div>
                    </div>

                    {{-- Empty state (hidden initially, shown after all removed) --}}
                    <div id="empty-wishlist-dynamic" style="display:none;text-align:center;padding:60px 0;">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity:.25;margin-bottom:16px;">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p style="color:#888;font-size:15px;">Your wishlist is empty.</p>
                        <a href="{{ route('shop') }}" style="display:inline-block;margin-top:12px;padding:9px 24px;
                                  background:#b8860b;color:#fff;border-radius:6px;font-size:14px;
                                  text-decoration:none;">
                            Continue Shopping
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        $(function() {

            // ── Single Row Remove ─────────────────────────────────────────
            $(document).on('click', '.wishlist-remove-btn', function() {
                const btn = $(this);
                const wishlistId = btn.data('id');
                const productId = btn.data('product-id');
                const row = $('#wishlist-row-' + wishlistId);

                btn.prop('disabled', true);

                $.ajax({
                    url: '/wishlist/remove-ajax/' + wishlistId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        // Row fade করে remove
                        row.fadeOut(300, function() {
                            $(this).remove();
                            updateAfterRemove(productId, res.count);
                        });
                        showToast('warning', 'Removed from wishlist!');
                    },
                    error: function() {
                        btn.prop('disabled', false);
                        showToast('error', 'Something went wrong!');
                    }
                });
            });

            // ── Clear All ─────────────────────────────────────────────────
            $(document).on('click', '#clear-all-btn', function() {
                const btn = $(this);
                btn.prop('disabled', true).text('Clearing...');

                $.ajax({
                    url: '/wishlist/clear',
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $('#wishlist-tbody tr').fadeOut(300, function() {
                            $(this).remove();
                            // সব গেলে empty state দেখাও
                            if ($('#wishlist-tbody tr').length === 0) {
                                showEmptyState();
                            }
                        });
                        // Header count শূন্য করো
                        $('#wishlist-count').hide();
                        showToast('warning', 'Wishlist cleared!');
                    },
                    error: function() {
                        btn.prop('disabled', false).text('Clear All');
                        showToast('error', 'Something went wrong!');
                    }
                });
            });

            // ── Helper: remove এর পর count ও state update ─────────────────
            function updateAfterRemove(productId, newCount) {
                // Product card এর heart un-active করো
                $('.wishlist-btn[data-product-id="' + productId + '"]').removeClass('active');

                // Header count update
                if (newCount > 0) {
                    $('#wishlist-count').text(newCount).show();
                } else {
                    $('#wishlist-count').hide();
                }

                // Table এ আর কোনো row নেই?
                if ($('#wishlist-tbody tr').length === 0) {
                    showEmptyState();
                }
            }

            // ── Helper: empty state দেখাও ──────────────────────────────────
            function showEmptyState() {
                $('#wishlist-table-wrap').hide();
                $('#clear-all-btn').hide();
                $('#empty-wishlist-dynamic').fadeIn(300);
            }

        });
    </script>
@endpush
