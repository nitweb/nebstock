<div class="offCanvas__minicart">
    <div class="minicart__header">
        <div class="minicart__header--top d-flex justify-content-between align-items-center">
            <h3 class="minicart__title">Shopping Cart (<span id="minicart-count">0</span>)</h3>
            <button class="minicart__close--btn" aria-label="minicart close btn" data-offcanvas>
                <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368" />
                </svg>
            </button>
        </div>
        <p class="minicart__header--desc">The Beauty and Cosmetic products are limited</p>
    </div>

    <!-- Cart Products - This will be loaded dynamically -->
    <div class="minicart__product" id="minicart-products">
        <!-- Products will load here via AJAX -->
        <div class="text-center py-4">
            <p>Loading cart...</p>
        </div>
    </div>

    <!-- Cart Totals -->
    <div class="minicart__amount">
        <div class="minicart__amount_list d-flex justify-content-between">
            <span>Sub Total:</span>
            <span><b id="minicart-subtotal">$0.00</b></span>
        </div>
        <div class="minicart__amount_list d-flex justify-content-between">
            <span>Total:</span>
            <span><b id="minicart-total">$0.00</b></span>
        </div>
    </div>

    <div class="minicart__conditions text-center">
        <input class="minicart__conditions--input" id="accept" type="checkbox">
        <label class="minicart__conditions--label" for="accept">
            I agree with the <a class="minicart__conditions--link" href="{{ route('privacy.policy') }}">Privacy Policy</a>
        </label>
    </div>

    <div class="minicart__button d-flex justify-content-center">
        <a class="primary__btn minicart__button--link" href="#!">View Cart</a>
        <a class="primary__btn minicart__button--link" href="#!">Checkout</a>
    </div>
</div>
