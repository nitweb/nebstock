<div class="newsletter-three padding-y-120">
    <div class="container container-two">
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="newsletter-three-content overflow-hidden z-index-1">
                    <img src="{{ asset('frontend/assets/images/gradients/newsletter-bg.png') }}" alt="" class="bg--gradient">
                    <img src="{{ asset('frontend/assets/images/thumbs/newsletter-img.png') }}" alt="" class="newsletter-three-content__img">
                    <h3 class="mb-3">Newsletter</h3>
                    <p class="mb-24 font-18">Subscribe our newsletter to get the latest news</p>
                    <form id="newsletterForm" class="search-box position-relative" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <input type="email" name="email" id="newsletterEmail" class="common-input common-input--lg shadow-sm" placeholder="Enter Mail" required>
                        <button type="submit" class="btn btn-main btn-lg">
                            <span class="d-sm-block d-none">Subscribe Now</span>
                            <span class="icon d-sm-none d-block"><i class="fas fa-bell"></i></span>
                        </button>
                    </form>
                    <div id="newsletterMsg" class="mt-2 font-14"></div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="newsletter-three-content support-content overflow-hidden z-index-1">
                    <img src="{{ asset('frontend/assets/images/gradients/support-gradient.png') }}" alt="" class="bg--gradient">
                    <img src="{{ asset('frontend/assets/images/shapes/arrow-round.png') }}" alt="" class="arrow-round">
                    <img src="{{ asset('frontend/assets/images/thumbs/newsletter-thumb.png') }}" alt="" class="newsletter-three-content__img">
                    <h3 class="mb-3">Support 24/7</h3>
                    <p class="mb-24 font-18">Wanna talk? Send us a message</p>
                    <a href="mailto:azency@office.com" class="btn btn-outline-black btn-lg">azency@office.com</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('newsletterForm');
    if (!form) return;
    const msgBox = document.getElementById('newsletterMsg');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const btn = form.querySelector('button[type="submit"]');
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="d-sm-block d-none">Subscribing...</span>';

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: new FormData(form),
        })
        .then(async (res) => {
            const data = await res.json();
            msgBox.textContent = data.message || '';
            msgBox.style.color = data.success ? '#28a745' : '#dc3545';
            if (data.success) form.reset();
        })
        .catch(() => {
            msgBox.textContent = 'Something went wrong. Please try again.';
            msgBox.style.color = '#dc3545';
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        });
    });
});
</script>
