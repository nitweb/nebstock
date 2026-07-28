<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>@yield('frontend_title') | Nicole Murray</title>

    <meta name="description" content="Nicole Murray is a global online store offering stylish clothing, trendy hats, and inspiring books. We bring quality, comfort, and modern lifestyle essentials to customers worldwide.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'Nicole Murray')">
    <meta property="og:description" content="@yield('og_description', 'Nicole Murray is a global online store offering stylish clothing, trendy hats, and inspiring books. We bring quality, comfort, and modern lifestyle essentials to customers worldwide.')">
    <meta property="og:image" content="@yield('og_image', asset('frontend/assets/img/logo/og_image.jpeg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Nicole Murray">

    <!-- Twitter Card (optional but recommended) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'Nicole Murray')">
    <meta name="twitter:description" content="@yield('og_description', 'Nicole Murray is a global online store offering stylish clothing, trendy hats, and inspiring books. We bring quality, comfort, and modern lifestyle essentials to customers worldwide.')">
    <meta name="twitter:image" content="@yield('og_image', asset('frontend/assets/img/logo/og_image.jpeg'))">

    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/favicon.png') }}">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendor/bootstrap.min.css') }}">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/glightbox.min.css') }}">

    <!-- CDN CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Frank+Ruhl+Libre:wght@300;400;500;700;900&family=Karma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS (last to override) -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}?v={{ filemtime(public_path('frontend/assets/css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}?v={{ filemtime(public_path('frontend/assets/css/custom.css')) }}">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        .cat-children {
            display: none;
        }

        /* arrow rotate */
        .cat-arrow {
            cursor: pointer;
            transition: 0.3s;
            font-size: 18px;
            margin-left: 6px;
        }

        .has-children.active>.cat-toggle .cat-arrow {
            transform: rotate(90deg);
        }

        /* hover feel */
        .cat-toggle {
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
        }

        .cat-toggle:hover {
            background: #f5f5f5;
        }
    </style>
</head>

<body>

    {{-- Preloader --}}
    @include('frontend.layouts.preloader')

    {{-- Header --}}
    {{-- @include('frontend.layouts.offcanvas_sidebar') --}}

    {{-- Header --}}
    @include('frontend.layouts.header')

    {{-- Index Page --}}
    <main class="main__content_wrapper">
        @yield('frontend_content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.footer')

    {{-- Quick View --}}
    @include('frontend.layouts.quick_view')

    @if (request()->is('/'))
        @include('frontend.layouts.newsletter_popup')
    @endif

    <button id="scroll__top">
        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M112 244l144-144 144 144M256 120v292" />
        </svg>
    </button>

    <!-- Vendor JS -->
    <script src="{{ asset('frontend/assets/js/vendor/popper.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.min.js') }}"></script>

    <!-- Plugin JS -->
    <script src="{{ asset('frontend/assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/glightbox.min.js') }}"></script>

    <!-- CDN JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('frontend/assets/js/script.js') }}?v={{ filemtime(public_path('frontend/assets/js/script.js')) }}"></script>

    <!-- Inline Script -->
    <script>
        $(function() {

            // ── CSRF Setup ────────────────────────────────────────
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ── Cart Count ────────────────────────────────────────
            loadCartCount();

            function loadCartCount() {
                $.get('/cart/count', function(res) {
                    $('#cart-count').text(res.count);
                });
            }

            // ── Add to Cart ───────────────────────────────────────
            // ── Add to Cart ───────────────────────────────────────
            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();

                const $btn = $(this);
                const originalHtml = $btn.html();

                // Product details page এ #product-qty থাকলে সেটা নেবে, না থাকলে 1
                const qty = $('#product-qty').length ? (parseInt($('#product-qty').val()) || 1) : 1;

                $btn.prop('disabled', true).html('Adding...');

                $.ajax({
                    url: '/cart/add',
                    method: 'POST',
                    data: {
                        product_id: $btn.data('product-id'),
                        quantity: qty,
                        is_pre_order: $btn.data('pre-order') == 1 ? 1 : 0
                    },
                    success: function(res) {
                        if (res.success) {
                            $('#cart-count').text(res.cart_count);
                            showToast('success', 'Product added to cart!');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401 && xhr.responseJSON?.redirect) {
                            showToast('warning', 'Please login to add items to cart...');
                            setTimeout(function() {
                                window.location.href = xhr.responseJSON.redirect;
                            }, 1200);
                        } else {
                            showToast('error', 'Failed to add product to cart');
                        }
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

            // ── Toast Config ──────────────────────────────────────
            const TOAST_CONFIG = {
                success: {
                    bg: '#15803D', // ← green
                    title: 'Success',
                    svg: '<path fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M20 6 9 17 4 12"/>'
                },
                error: {
                    bg: '#B91C1C', // ← red (এটা ঠিক আছে)
                    title: 'Error',
                    svg: '<circle cx="12" cy="12" r="10" stroke="#fff" fill="none" stroke-width="2.5"/><line x1="12" y1="8" x2="12" y2="13" stroke="#fff" stroke-width="2.5"/><circle cx="12" cy="16.5" r="1" fill="#fff"/>'
                },
                warning: {
                    bg: '#92400E', // ← amber (এটা ঠিক আছে)
                    title: 'Warning',
                    svg: '<path fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13" stroke="#fff" stroke-width="2.5"/><circle cx="12" cy="17" r="1" fill="#fff"/>'
                },
            };

            // ── Build Toast Node ──────────────────────────────────
            function buildToastNode(cfg, message) {
                const wrap = document.createElement('div');
                wrap.innerHTML = `
                    <div style="display:flex;align-items:center;gap:12px;
                                background:${cfg.bg};padding:14px 18px;
                                border-radius:12px;min-width:260px;
                                box-shadow:0 4px 20px rgba(0,0,0,.25);">
                        <span style="width:34px;height:34px;flex-shrink:0;border-radius:50%;
                                     border:2px solid rgba(255,255,255,.35);display:flex;
                                     align-items:center;justify-content:center;">
                            <svg viewBox="0 0 24 24" width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                ${cfg.svg}
                            </svg>
                        </span>
                        <div>
                            <p style="margin:0;font-weight:500;color:#fff;font-size:13px;">${cfg.title}</p>
                            <p style="margin:2px 0 0;color:rgba(255,255,255,.75);font-size:12px;">${message}</p>
                        </div>
                    </div>`;
                return wrap;
            }

            // ── Show Toast ────────────────────────────────────────
            function showToast(type, message) {
                const cfg = TOAST_CONFIG[type];
                if (!cfg) return;

                Toastify({
                    node: buildToastNode(cfg, message),
                    duration: 3000,
                    gravity: 'bottom',
                    position: 'right',
                    style: {
                        background: 'transparent',
                        padding: '0',
                        boxShadow: 'none'
                    },
                    stopOnFocus: true,
                }).showToast();
            }

            // ── Expose globally (optional — for use in other scripts) ──
            window.showToast = showToast;

        });
    </script>

    <script>
        // ── Wishlist Count & Active State ─────────────────────────
        loadWishlistCount();
        markWishlistedProducts();

        function loadWishlistCount() {
            $.get('/wishlist/count', function(res) {
                if (res.count > 0) {
                    $('#wishlist-count').text(res.count).show();
                } else {
                    $('#wishlist-count').hide();
                }
            });
        }

        // Page load এ সব wishlisted products mark করো
        function markWishlistedProducts() {
            $.get('/wishlist/product-ids', function(res) {
                if (res.ids && res.ids.length > 0) {
                    res.ids.forEach(function(productId) {
                        // প্রতিটি wishlist button এ data-product-id মিলিয়ে active করো
                        $('.wishlist-btn[data-product-id="' + productId + '"]')
                            .addClass('active');
                    });
                }
            });
        }

        // ── Wishlist Toggle ───────────────────────────────────────
        $(document).on('click', '.wishlist-btn', function() {
            const btn = $(this);
            const productId = btn.data('product-id');

            $.ajax({
                url: "{{ route('wishlist.toggle') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(res) {
                    if (res.status === 'added') {
                        btn.addClass('active');
                        showToast('success', res.message);
                    } else {
                        btn.removeClass('active');
                        showToast('warning', res.message);
                    }

                    // Count update
                    if (res.count > 0) {
                        $('#wishlist-count').text(res.count).show();
                    } else {
                        $('#wishlist-count').hide();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        showToast('warning', 'Please login first...');
                        setTimeout(function() {
                            window.location.href = "{{ route('customer.login') }}";
                        }, 1200);
                    } else if (xhr.status === 419) {
                        showToast('error', 'Session expired. Please refresh!');
                    } else {
                        showToast('error', 'Something went wrong!');
                    }
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.cat-toggle', function(e) {

            e.stopPropagation(); // 🔥 MAIN FIX (bubble stop)

            // jodi category link e click hoy → accordion trigger hobe na
            if ($(e.target).closest('[data-cat-slug]').length) {
                return;
            }

            let parent = $(this).closest('.has-children');
            let child = parent.children('.cat-children');

            child.stop(true, true);

            if (parent.hasClass('active')) {
                child.slideUp(200);
                parent.removeClass('active');
            } else {
                child.slideDown(200);
                parent.addClass('active');
            }
        });
    </script>

    <script>
        (function() {

            function initNewsletter(formSelector, emailSelector, btnSelector) {
                const form = document.querySelector(formSelector);
                if (!form) return;

                const emailEl = form.querySelector(emailSelector);
                const btn = form.querySelector(btnSelector);
                const btnText = btn?.querySelector('.nl-btn-text');
                const loader = btn?.querySelector('.nl-btn-loader');

                function setLoading(state) {
                    if (!btn) return;
                    btn.disabled = state;
                    if (btnText) btnText.style.display = state ? 'none' : 'inline';
                    if (loader) loader.style.display = state ? 'inline-flex' : 'none';
                }

                emailEl.addEventListener('input', () => emailEl.classList.remove('nl-invalid'));

                form.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const email = emailEl.value.trim();

                    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        emailEl.classList.add('nl-invalid');
                        window.showToast('error', 'Please enter a valid email address.');
                        return;
                    }

                    setLoading(true);

                    try {
                        const res = await fetch('{{ route('newsletter.subscribe') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                email
                            }),
                        });

                        const data = await res.json();

                        window.showToast(data.success ? 'success' : 'error', data.message);

                        if (data.success) emailEl.value = '';

                    } catch (err) {
                        window.showToast('error', 'An unexpected server error occurred. Please try again later.');
                    } finally {
                        setLoading(false);
                    }
                });
            }

            // Initialize footer newsletter form
            initNewsletter('#footerNewsletterForm', '#footerNewsletterEmail', '#footerNewsletterBtn');

            // Initialize popup newsletter form
            initNewsletter('.newsletter__popup--subscribe__form', '.newsletter__popup--subscribe__input', '.newsletter__popup--subscribe__btn');

        })();
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.querySelector('.newsletter__popup');
            const closeBtn = document.querySelector('.newsletter__popup--close__btn');
            closeBtn?.addEventListener('click', function() {
                popup?.classList.add('hidden');
            });
        });
    </script>

    @stack('scripts')

</body>

</html>
