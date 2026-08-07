<section class="hero section-bg z-index-1">
    <img src="{{ asset('frontend/assets/images/gradients/banner-gradient.png') }}" alt="" class="bg--gradient white-version">
    <img src="{{ asset('frontend/assets/images/shapes/element-moon2.png') }}" alt="" class="element two">

    <div class="container container-two">
        <div class="row align-items-center gy-sm-5 gy-4">
            <div class="col-lg-6">
                <div class="hero-inner position-relative pe-lg-5">
                    <div>
                        <h1 class="hero-inner__title">2M+ curated digital products</h1>
                        <p class="hero-inner__desc font-18">Explore the best premium themes and plugins available for sale. Our unique collection is hand-curated by experts. Find and buy the perfect premium theme today.</p>

                        <div class="position-relative">
                            <div class="search-box">
                                <input type="text" class="common-input common-input--lg pill shadow-sm auto-suggestion-input" placeholder="Search theme, plugins & more...">
                                <button type="submit" class="btn btn-main btn-icon icon border-0"><img src="{{ asset('frontend/assets/images/icons/search.svg') }}" alt=""></button>
                            </div>

                            <ul class="auto-suggestion-list">
                                <li>
                                    <a href="#" class="auto-suggestion-list__item w-100 text-body">Business in HTML</a>
                                </li>
                                <li>
                                    <a href="#" class="auto-suggestion-list__item w-100 text-body">Business in WordPress</a>
                                </li>
                                <li>
                                    <a href="#" class="auto-suggestion-list__item w-100 text-body">Business in CMS</a>
                                </li>
                                <li>
                                    <a href="#" class="auto-suggestion-list__item w-100 text-body">Ecommerce in HTML</a>
                                </li>
                                <li>
                                    <a href="#" class="auto-suggestion-list__item w-100 text-body">Ecommerce in WordPress</a>
                                </li>
                                <li>
                                    <a href="#" class="auto-suggestion-list__item w-100 text-body">Ecommerce in CMS</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Feature Pills Start -->
                        <div class="feature-pill-list d-flex flex-wrap gap-2">
                            <a href="#" class="feature-pill">
                                <img src="{{ asset('frontend/assets/images/icons/metadata-icon.png') }}" alt="" width="14" height="14">
                                <span>Metadata Generation</span>
                            </a>
                            <a href="#" class="feature-pill">
                                <img src="{{ asset('frontend/assets/images/icons/image2prompt-icon.png') }}" alt="" width="14" height="14">
                                <span>Image2Prompt Generate</span>
                            </a>
                            <a href="#" class="feature-pill">
                                <img src="{{ asset('frontend/assets/images/icons/image-gen-icon.png') }}" alt="" width="14" height="14">
                                <span>Image Generation</span>
                            </a>
                            <a href="#" class="feature-pill">
                                <img src="{{ asset('frontend/assets/images/icons/ai-prompt-icon.png') }}" alt="" width="14" height="14">
                                <span>AI Prompt Generate</span>
                            </a>
                            <a href="#" class="feature-pill">
                                <img src="{{ asset('frontend/assets/images/icons/qr-gen-icon.png') }}" alt="" width="14" height="14">
                                <span>QR Code Generate</span>
                            </a>
                        </div>
                        <!-- Feature Pills End -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-thumb">
                    <img src="{{ asset('frontend/assets/images/thumbs/banner-img.png') }}" alt="">
                    <img src="{{ asset('frontend/assets/images/shapes/dots.png') }}" alt="" class="dotted-img white-version">
                    <img src="{{ asset('frontend/assets/images/shapes/dots-white.png') }}" alt="" class="dotted-img dark-version">

                    <div class="statistics animation bg-main text-center">
                        <h5 class="statistics__amount text-white">50k</h5>
                        <span class="statistics__text text-white font-14">Customers</span>
                    </div>

                    <div class="statistics style-two bg-white text-center">
                        <h5 class="statistics__amount statistics__amount-two text-heading">22k</h5>
                        <span class="statistics__text text-heading font-14">Themes & Plugins</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
.feature-pill-list {
    margin-top: 20px;
}

.feature-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 30px;
    background-color: #eef2ff;
    border: 1px solid #d6dcfb;
    color: #686973;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.25s ease;
    white-space: nowrap;
}

.feature-pill img {
    width: 14px;
    height: 14px;
    object-fit: contain;
}

.feature-pill:hover {
    background-color: #4640de;
    border-color: #4640de;
    color: #ffffff;
}

.feature-pill:hover img {
    filter: brightness(0) invert(1);
}
</style>