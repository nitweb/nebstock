<div class="predictive__search--box">
    <div class="predictive__search--box__inner">
        <h2 class="predictive__search--title">Search Products</h2>
        <form class="predictive__search--form" action="#" autocomplete="off">
            <label style="position: relative; flex: 1;">
                <input id="ajax-search-input" class="predictive__search--input" placeholder="Search Here" type="text" autocomplete="off">
            </label>
            <button class="predictive__search--button text-white" aria-label="search button">
                <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="30.51" height="25.443" viewBox="0 0 512 512">
                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448" />
                </svg>
            </button>
        </form>

        {{-- Search Results Container --}}
        <div id="ajax-search-results" style="display:none; margin-top: 16px;">
            <div id="search-results-grid" style="
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 12px;
                max-height: 420px;
                overflow-y: auto;
                padding-right: 4px;
            "></div>
            <p id="search-no-results" style="display:none; text-align:center; color:#888; padding: 20px 0; font-size: 14px;">
                No products found.
            </p>
        </div>
    </div>

    <button class="predictive__search--close__btn" aria-label="search close" data-offcanvas>
        <svg class="predictive__search--close__icon" xmlns="http://www.w3.org/2000/svg" width="40.51" height="30.443" viewBox="0 0 512 512">
            <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368" />
        </svg>
    </button>
</div>

<style>
    .search-product-card {
        display: flex;
        flex-direction: column;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        transition: box-shadow 0.2s, transform 0.2s;
        background: #fff;
    }

    .search-product-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.10);
        transform: translateY(-2px);
        text-decoration: none;
        color: inherit;
    }

    .search-product-card__img-wrap {
        width: 100%;
        aspect-ratio: 3/4;
        background: #f5f5f5;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-product-card__img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .search-product-card__body {
        padding: 8px 10px 10px;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .search-product-card__name {
        font-size: 13px;
        font-weight: 600;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #222;
    }

    .search-product-card__author {
        font-size: 11px;
        color: #888;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .search-product-card__price {
        font-size: 13px;
        font-weight: 700;
        color: #B8860B;
        margin-top: 2px;
    }

    .search-product-card__old-price {
        font-size: 11px;
        color: #aaa;
        text-decoration: line-through;
        margin-left: 4px;
    }

    #search-results-grid::-webkit-scrollbar {
        width: 4px;
    }

    #search-results-grid::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 4px;
    }

    .search-spinner {
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }

    .search-spinner span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #B8860B;
        display: inline-block;
        margin: 0 3px;
        animation: searchBounce 1s infinite ease-in-out;
    }

    .search-spinner span:nth-child(2) {
        animation-delay: 0.15s;
    }

    .search-spinner span:nth-child(3) {
        animation-delay: 0.3s;
    }

    @keyframes searchBounce {

        0%,
        80%,
        100% {
            transform: scale(0.7);
            opacity: 0.5;
        }

        40% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<script>
    (function() {
        const input = document.getElementById('ajax-search-input');
        const wrapper = document.getElementById('ajax-search-results');
        const grid = document.getElementById('search-results-grid');
        const noRes = document.getElementById('search-no-results');
        let timer = null;

        function showSpinner() {
            grid.innerHTML = '<div class="search-spinner"><span></span><span></span><span></span></div>';
            noRes.style.display = 'none';
            wrapper.style.display = 'block';
        }

        function buildCard(product) {
            const price = parseFloat(product.sellingPrice || 0).toFixed(2);
            const oldPrice = product.original_price ?
                `<span class="search-product-card__old-price">৳${parseFloat(product.original_price).toFixed(2)}</span>` :
                '';
            const author = product.authorNames ?
                `<span class="search-product-card__author">${product.authorNames}</span>` :
                '';

            return `
        <a href="${product.url}" class="search-product-card">
            <div class="search-product-card__img-wrap">
                <img src="${product.coverImage}" alt="${product.name}" loading="lazy">
            </div>
            <div class="search-product-card__body">
                <span class="search-product-card__name">${product.name}</span>
                ${author}
                <div>
                    <span class="search-product-card__price">৳${price}</span>
                    ${oldPrice}
                </div>
            </div>
        </a>`;
        }

        function doSearch(query) {
            if (query.length < 2) {
                wrapper.style.display = 'none';
                return;
            }

            showSpinner();

            fetch(`{{ route('ajax.search') }}?query=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    grid.innerHTML = '';

                    if (!data.products || data.products.length === 0) {
                        noRes.style.display = 'block';
                        return;
                    }

                    noRes.style.display = 'none';
                    data.products.forEach(p => {
                        grid.insertAdjacentHTML('beforeend', buildCard(p));
                    });
                })
                .catch(() => {
                    grid.innerHTML = '<p style="text-align:center;color:#888;padding:16px;">Something went wrong.</p>';
                });
        }

        input.addEventListener('input', function() {
            clearTimeout(timer);
            const q = this.value.trim();
            if (q.length < 2) {
                wrapper.style.display = 'none';
                return;
            }
            timer = setTimeout(() => doSearch(q), 350);
        });

        // Hide on outside click
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.predictive__search--box__inner')) {
                wrapper.style.display = 'none';
            }
        });
    })();
</script>
