<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog quickview__main--wrapper modal-dialog-centered modal-xl">
        <div class="modal-content quickview__main__content">

            <div class="modal-header quickview_m_header border-0 pb-0">
                <button type="button" class="btn-close quickview__close--btn" data-bs-dismiss="modal" aria-label="Close">✕</button>
            </div>

            <div class="modal-body quickview__inner pt-0">

                {{-- Loading --}}
                <div id="qv-loading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted small">Loading product…</p>
                </div>

                {{-- Content --}}
                <div id="qv-content" style="display:none;">
                    <div class="row row-cols-lg-2 row-cols-md-2">

                        {{-- ── Gallery ─────────────────────────────────────── --}}
                        <div class="col">
                            <div class="quickview__gallery">
                                <div class="product__media--preview swiper" id="qv-main-slider">
                                    <div class="swiper-wrapper" id="qv-main-images"></div>
                                </div>
                                <div class="product__media--nav swiper mt-2" id="qv-thumb-slider">
                                    <div class="swiper-wrapper" id="qv-thumb-images"></div>
                                    <div class="swiper__nav--btn swiper-button-next"></div>
                                    <div class="swiper__nav--btn swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>

                        {{-- ── Info ────────────────────────────────────────── --}}
                        <div class="col">
                            <div class="quickview__info">

                                {{-- Name --}}
                                <h2 class="product__details--info__title mb-10" id="qv-name"></h2>

                                {{-- Author --}}
                                <p class="mb-10" id="qv-authors" style="font-size:14px;color:#888;"></p>

                                {{-- Stars --}}
                                {{-- <div class="d-flex align-items-center gap-2 mb-15">
                                    <ul class="d-flex gap-1" id="qv-stars" style="list-style:none;padding:0;margin:0;"></ul>
                                    <span id="qv-review-count" style="font-size:13px;color:#aaa;"></span>
                                </div> --}}

                                {{-- Price --}}
                                <div class="product__card--price mb-15" id="qv-price"></div>

                                {{-- Stock --}}
                                <div class="mb-15" id="qv-stock"></div>

                                {{-- Short Desc --}}
                                <p class="product__details--info__desc mb-15" id="qv-desc"></p>

                                <hr>

                                {{-- View Details --}}
                                <a id="qv-link" href="#" class="primary__btn" style="display:inline-flex;align-items:center;gap:6px;margin-top:8px; padding: 5px 40px 0px; height: inherit; line-height: 3;">
                                    View Full Details
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="margin-top: -5px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Quick View Gallery */
    #qv-main-slider .swiper-slide img {
        width: 100%;
        height: 360px;
        object-fit: contain;
        padding: 16px;
        background: #f9f9f9;
        border-radius: 8px;
    }

    #qv-thumb-slider .swiper-slide {
        width: 72px !important;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 6px;
        overflow: hidden;
        opacity: .6;
        transition: opacity .2s, border-color .2s;
    }

    #qv-thumb-slider .swiper-slide-thumb-active {
        opacity: 1;
        border-color: #B8860B;
    }

    #qv-thumb-slider img {
        width: 72px;
        height: 72px;
        object-fit: cover;
        display: block;
    }

    /* Price in quick view */
    #qv-price .current__price {
        font-size: 24px;
        font-weight: 800;
        color: #B8860B;
    }

    #qv-price .old__price {
        font-size: 16px;
        color: #aaa;
        text-decoration: line-through;
        margin-left: 8px;
    }

    #qv-price .disc__badge {
        font-size: 12px;
        background: #B8860B;
        color: #fff;
        padding: 2px 9px;
        border-radius: 20px;
        margin-left: 8px;
        vertical-align: middle;
    }

    /* Stars */
    #qv-stars li {
        list-style: none;
    }

    #qv-stars .star-filled {
        color: #f5a623;
    }

    #qv-stars .star-empty {
        color: #ddd;
    }
</style>

<script>
    $(function() {

        let qvMainSwiper = null;
        let qvThumbSwiper = null;

        // ── Open quick view ───────────────────────────────────────────────────────
        $(document).on('click', '.quick-view-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('product-id');
            if (!id) return;

            // Reset & open modal
            resetQV();
            const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            modal.show();

            $.ajax({
                url: `/product/quick-view/${id}`,
                method: 'GET',
                success(res) {
                    if (res.success) {
                        populateQV(res);
                        $('#qv-loading').hide();
                        $('#qv-content').show();
                    } else {
                        modal.hide();
                    }
                },
                error() {
                    modal.hide();
                }
            });
        });

        // ── Cleanup on close ──────────────────────────────────────────────────────
        document.getElementById('quickViewModal').addEventListener('hidden.bs.modal', resetQV);

        // ── Reset ─────────────────────────────────────────────────────────────────
        function resetQV() {
            $('#qv-loading').show();
            $('#qv-content').hide();
            $('#qv-main-images, #qv-thumb-images').html('');
            if (qvMainSwiper) {
                qvMainSwiper.destroy(true, true);
                qvMainSwiper = null;
            }
            if (qvThumbSwiper) {
                qvThumbSwiper.destroy(true, true);
                qvThumbSwiper = null;
            }
        }

        // ── Populate ──────────────────────────────────────────────────────────────
        function populateQV(data) {
            const p = data.product;
            const galleryBase = '{{ asset('upload/product_gallery') }}';

            // Name
            $('#qv-name').text(p.name ?? '');

            // Authors
            const auth = data.authorNames || '';
            auth ? $('#qv-authors').text('by ' + auth).show() : $('#qv-authors').hide();

            // Stars
            const rating = Math.round(parseFloat(data.avgRating) || 0);
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += `<li><span class="${i <= rating ? 'star-filled' : 'star-empty'}">★</span></li>`;
            }
            $('#qv-stars').html(starsHtml);
            $('#qv-review-count').text(
                data.reviewCount > 0 ? `(${data.reviewCount} review${data.reviewCount > 1 ? 's' : ''})` : '(No reviews)'
            );

            // Price
            let priceHtml = `<span class="current__price">$${parseFloat(data.sellingPrice).toFixed(2)}</span>`;
            if (p.discount_price && parseFloat(p.discount_price) > 0) {
                priceHtml += `<span class="old__price">$${parseFloat(p.price).toFixed(2)}</span>`;
                if (data.discountPercent > 0) {
                    priceHtml += `<span class="disc__badge">-${data.discountPercent}%</span>`;
                }
            }
            $('#qv-price').html(priceHtml);

            // Stock
            $('#qv-stock').html(
                p.stock_status === 'in_stock' ?
                '<span class="badge bg-success px-3" style="padding: 7px 20px 3px;">In Stock</span>' :
                '<span class="badge bg-danger  px-3" style="padding: 7px 20px 3px;">Out of Stock</span>'
            );

            // Short desc
            $('#qv-desc').text(p.short_description || '');

            // Details link
            $('#qv-link').attr('href', `/product/${p.slug}`);

            // ── Gallery slides ────────────────────────────────────────────────────
            let mainHtml = '';
            let thumbHtml = '';

            // Cover
            const cover = data.coverImage;
            mainHtml += slideMain(cover);
            thumbHtml += slideThumb(cover);

            // Gallery images
            if (p.gallery_images && p.gallery_images.length) {
                p.gallery_images.forEach(img => {
                    const url = galleryBase + '/' + img.file_path;
                    mainHtml += slideMain(url);
                    thumbHtml += slideThumb(url);
                });
            }

            $('#qv-main-images').html(mainHtml);
            $('#qv-thumb-images').html(thumbHtml);

            setTimeout(initSwipers, 120);
        }

        function slideMain(url) {
            return `<div class="swiper-slide"><img src="${url}" alt="product" loading="lazy"></div>`;
        }

        function slideThumb(url) {
            return `<div class="swiper-slide"><img src="${url}" alt="thumb" loading="lazy"></div>`;
        }

        function initSwipers() {
            if (qvMainSwiper) {
                qvMainSwiper.destroy(true, true);
            }
            if (qvThumbSwiper) {
                qvThumbSwiper.destroy(true, true);
            }

            qvThumbSwiper = new Swiper('#qv-thumb-slider', {
                spaceBetween: 8,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesProgress: true,
                navigation: {
                    nextEl: '#qv-thumb-slider .swiper-button-next',
                    prevEl: '#qv-thumb-slider .swiper-button-prev',
                },
            });

            qvMainSwiper = new Swiper('#qv-main-slider', {
                spaceBetween: 10,
                thumbs: {
                    swiper: qvThumbSwiper
                },
            });
        }

    });
</script>
