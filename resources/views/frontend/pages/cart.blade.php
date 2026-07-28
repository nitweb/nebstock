@extends('frontend.dashboard')
@section('frontend_title', 'Shopping Cart')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Shopping Cart</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Cart</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== -->
    <!-- CUSTOM CONFIRM MODAL  -->
    <!-- ===================== -->
    <div class="cart-modal-overlay" id="cartModal">
        <div class="cart-modal-box">
            <div class="cart-modal-icon" id="cartModalIcon">
                <!-- icon injected by JS -->
            </div>
            <h4 class="cart-modal-title" id="cartModalTitle">Are you sure?</h4>
            <p class="cart-modal-desc" id="cartModalDesc">This action cannot be undone.</p>
            <div class="cart-modal-actions">
                <button class="cart-modal-cancel" id="cartModalCancel">Cancel</button>
                <button class="cart-modal-confirm" id="cartModalConfirm">Yes, remove</button>
            </div>
        </div>
    </div>

    <!-- cart section start -->
    <section class="cart__section section--padding">
        <div class="container">
            <div class="cart__section--inner">
                <h2 class="cart__title">Shopping Cart</h2>

                @if ($cartItems->count() > 0)
                    <div class="row">
                        <div class="col-12">
                            <div class="cart__table">
                                <table class="cart__table--inner">
                                    <thead class="cart__table--header">
                                        <tr class="cart__table--header__items">
                                            <th class="cart__table--header__list">Product</th>
                                            <th class="cart__table--header__list">Price</th>
                                            <th class="cart__table--header__list">Quantity</th>
                                            <th class="cart__table--header__list">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart__table--body" id="cart-table-body">
                                        @foreach ($cartItems as $item)
                                            @php
                                                // discount_price থাকলে সেটাই final price
                                                $price = $item->product->discount_price ?? $item->product->price;
                                                $itemTotal = $price * $item->quantity;
                                            @endphp
                                            <tr class="cart__table--body__items" data-cart-id="{{ $item->id }}">
                                                <td class="cart__table--body__list">
                                                    <div class="cart__product d-flex align-items-center">
                                                        <button class="cart__remove--btn remove-cart-item" data-cart-id="{{ $item->id }}" aria-label="remove item" type="button">
                                                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="10px" height="10px">
                                                                <path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z" />
                                                            </svg>
                                                        </button>
                                                        <div class="cart__thumbnail">
                                                            <a href="{{ route('product.details', $item->product->slug) }}">
                                                                <img src="{{ asset('upload/product_covers/' . $item->product->cover_image) }}" alt="{{ $item->product->name }}">
                                                            </a>
                                                        </div>
                                                        <div class="cart__content">
                                                            <h3 class="cart__content--title h4">
                                                                <a href="{{ route('product.details', $item->product->slug) }}">
                                                                    {{ Str::limit($item->product->name, 70) }}
                                                                </a>
                                                            </h3>

                                                            {{-- ✅ Product Status Badge in Cart --}}
                                                            @if ($item->product->is_pre_order)
                                                                <span style="font-size:11px; color:#e67e22; font-weight:600;">
                                                                    🕐 Pre-Order
                                                                    {{ $item->product->pre_order_date ? '· Ships ' . $item->product->pre_order_date->format('d M Y') : '· Coming Soon' }}
                                                                </span>
                                                            @elseif ($item->product->stock_status === 'out_of_stock')
                                                                <span style="font-size:11px; color:#e67e22; font-weight:600;">
                                                                    🕐 Pre-Order · Out of Stock
                                                                </span>
                                                            @endif
                                                            {{-- In Stock হলে কিছুই দেখাবে না --}}

                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart__table--body__list">
                                                    <span class="cart__price">${{ number_format($price, 2) }}</span>
                                                </td>
                                                <td class="cart__table--body__list">
                                                    <div class="quantity__box">
                                                        <button type="button" class="quantity__value decrease cart-qty-btn" data-cart-id="{{ $item->id }}" data-action="decrease" aria-label="decrease quantity">−</button>
                                                        <input type="number" class="quantity__number" value="{{ $item->quantity }}" data-cart-id="{{ $item->id }}" readonly />
                                                        <button type="button" class="quantity__value increase cart-qty-btn" data-cart-id="{{ $item->id }}" data-action="increase" aria-label="increase quantity">+</button>
                                                    </div>
                                                </td>
                                                <td class="cart__table--body__list">
                                                    <span class="cart__price end item-total">${{ number_format($itemTotal, 2) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Bottom bar -->
                                <div class="cart__bottom-bar">
                                    <div class="left-actions">
                                        <a class="continue__shopping--link" href="{{ url('/shop') }}">← Continue shopping</a>
                                        <button class="continue__shopping--clear" type="button" id="clear-cart-btn">Clear Cart</button>
                                    </div>
                                    <div class="cart__checkout-group">
                                        <div class="cart__grand-total-box">
                                            <span class="label">Grand Total</span>
                                            <span class="amount" id="cart-total">${{ number_format($subtotal, 2) }}</span>
                                        </div>
                                        <a class="checkout__btn" href="{{ route('checkout') }}">Proceed to Checkout →</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12">
                            <div class="empty-cart text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#999" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </svg>
                                <h3>Your cart is empty</h3>
                                <p>Looks like you haven't added any products yet.</p>
                                <a href="{{ url('/shop') }}" class="primary__btn">Start Shopping</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Inline Script -->
    <script>
        $(document).ready(function() {

            // ============================================
            // CUSTOM MODAL HELPER
            // ============================================
            let modalCallback = null;

            function showModal(type, title, desc, confirmText) {
                $('#cartModalTitle').text(title);
                $('#cartModalDesc').text(desc);
                $('#cartModalConfirm').text(confirmText || 'Yes');

                // Icon
                let iconHtml = '';
                if (type === 'remove') {
                    $('#cartModalIcon').attr('class', 'cart-modal-icon danger');
                    iconHtml = `<svg fill="#c0614a" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px">
                        <path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"/>
                    </svg>`;
                } else {
                    $('#cartModalIcon').attr('class', 'cart-modal-icon warning');
                    iconHtml = `<svg fill="#c97050" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>`;
                }
                $('#cartModalIcon').html(iconHtml);

                $('#cartModal').addClass('active');
            }

            function hideModal() {
                $('#cartModal').removeClass('active');
                modalCallback = null;
            }

            // Close on overlay click
            $('#cartModal').on('click', function(e) {
                if ($(e.target).is('#cartModal')) hideModal();
            });

            $('#cartModalCancel').on('click', function() {
                hideModal();
            });

            $('#cartModalConfirm').on('click', function() {
                if (typeof modalCallback === 'function') {
                    modalCallback();
                }
                hideModal();
            });

            // ============================================
            // QUANTITY INCREASE / DECREASE
            // ============================================
            $(document).on('click', '.cart-qty-btn', function() {
                let cartId = $(this).data('cart-id');
                let action = $(this).data('action');
                let row = $(this).closest('tr');
                let input = row.find('.quantity__number');
                let currentQty = parseInt(input.val());

                if (action === 'decrease' && currentQty <= 1) {
                    showToast('warning', 'Minimum quantity is 1');
                    return;
                }

                let change = action === 'increase' ? 1 : -1;
                row.find('.cart-qty-btn').prop('disabled', true);

                $.ajax({
                    url: '/cart/update-quantity',
                    method: 'POST',
                    data: {
                        cart_id: cartId,
                        change: change
                    },
                    success: function(response) {
                        if (response.success) {
                            let newQty = currentQty + change;
                            input.val(newQty);

                            // ✅ comma remove করে parse করো
                            let priceText = row.find('.cart__price').first().text();
                            let price = parseFloat(priceText.replace('$', '').replace(/,/g, ''));
                            let newTotal = price * newQty;

                            row.find('.item-total').text('$' + newTotal.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));

                            updateCartTotal();
                            loadCartCount();
                        }
                    },
                    error: function() {
                        showToast('error', 'Failed to update quantity');
                    },
                    complete: function() {
                        row.find('.cart-qty-btn').prop('disabled', false);
                    }
                });
            });

            // ============================================
            // REMOVE ITEM
            // ============================================
            $(document).on('click', '.remove-cart-item', function() {
                let cartId = $(this).data('cart-id');
                let row = $(this).closest('tr');

                showModal('remove', 'Remove item?', 'This item will be removed from your cart.', 'Yes, remove');

                modalCallback = function() {
                    row.css('opacity', '0.4');

                    $.ajax({
                        url: '/cart/remove/' + cartId,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                    if ($('#cart-table-body tr').length === 0) {
                                        location.reload();
                                    }
                                    updateCartTotal();
                                    loadCartCount();
                                });
                                showToast('success', 'Item removed from cart');
                            }
                        },
                        error: function() {
                            row.css('opacity', '1');
                            showToast('error', 'Failed to remove item');
                        }
                    });
                };
            });

            // ============================================
            // CLEAR CART
            // ============================================
            $('#clear-cart-btn').on('click', function() {
                showModal('clear', 'Clear entire cart?', 'All items will be removed. This cannot be undone.', 'Yes, clear all');

                modalCallback = function() {
                    $.ajax({
                        url: '/cart/clear',
                        method: 'POST',
                        success: function(response) {
                            if (response.success) {
                                showToast('success', 'Cart cleared');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function() {
                            showToast('error', 'Failed to clear cart');
                        }
                    });
                };
            });

            // ============================================
            // UPDATE GRAND TOTAL
            // ============================================
            function updateCartTotal() {
                let total = 0;
                $('#cart-table-body tr').each(function() {
                    // ✅ comma remove করে parse করো
                    let val = parseFloat($(this).find('.item-total').text().replace('$', '').replace(/,/g, ''));
                    if (!isNaN(val)) total += val;
                });
                $('#cart-total').text('$' + total.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }

            // ============================================
            // HEADER CART COUNT
            // ============================================
            function loadCartCount() {
                $.ajax({
                    url: '/cart/count',
                    method: 'GET',
                    success: function(response) {
                        $('#cart-count').text(response.count);
                    }
                });
            }

            // ============================================
            // TOAST
            // ============================================
            function showToast(type, message) {
                let bgColor = '#28a745';
                if (type === 'error') bgColor = '#dc3545';
                if (type === 'warning') bgColor = '#e0a020';

                if (typeof Toastify !== 'undefined') {
                    Toastify({
                        text: message,
                        duration: 3000,
                        gravity: 'bottom',
                        position: 'right',
                        backgroundColor: bgColor,
                        stopOnFocus: true,
                        close: true
                    }).showToast();
                } else {
                    alert(message);
                }
            }

        });
    </script>

@endsection
