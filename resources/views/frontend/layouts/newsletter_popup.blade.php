<div class="newsletter__popup" data-animation="slideInUp">
    <div id="boxes" class="newsletter__popup--inner">

        <button class="newsletter__popup--close__btn" aria-label="search close button">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"></path>
            </svg>
        </button>

        <div class="box newsletter__popup--box d-flex align-items-center">

            <div class="newsletter__popup--thumbnail">
                <img class="newsletter__popup--thumbnail__img display-block" src="{{ asset('upload/static_images/newsletter.jpg') }}" alt="newsletter-popup-thumb">
            </div>

            <div class="newsletter__popup--box__right">
                <h2 class="newsletter__popup--title">Join Our Newsletter</h2>
                <div class="newsletter__popup--content">
                    <label class="newsletter__popup--content--desc">Enter your email address to subscribe our notification of our new post &amp; features by email.</label>
                    <div class="newsletter__popup--subscribe" id="frm_subscribe">
                        <form class="newsletter__popup--subscribe__form">
                            <input class="newsletter__popup--subscribe__input" type="text" placeholder="Enter your email address here...">
                            <button class="newsletter__popup--subscribe__btn" type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Hide popup instantly if already dismissed --}}
<script>
    if (localStorage.getItem('newsletter__show')) {
        document.querySelector('.newsletter__popup')?.remove();
    }
</script>
