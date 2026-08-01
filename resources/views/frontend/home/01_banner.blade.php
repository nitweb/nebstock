<section class="hero section-bg z-index-1">

    <img src="{{ asset('frontend/assets/images/gradients/banner-gradient.png') }}" alt="" class="bg--gradient white-version">
    <img src="{{ asset('frontend/assets/images/shapes/element-moon1.png') }}" alt="" class="element one">
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
                                    <a href="javascript:void(0)" class="auto-suggestion-list__item w-100 text-body">Business in HTML</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="auto-suggestion-list__item w-100 text-body">Business in WordPress</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="auto-suggestion-list__item w-100 text-body">Business in CMS</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="auto-suggestion-list__item w-100 text-body">Ecommerce in HTML</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="auto-suggestion-list__item w-100 text-body">Ecommerce in WordPress</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="auto-suggestion-list__item w-100 text-body">Ecommerce in CMS</a>
                                </li>
                            </ul>

                        </div>

                        <!-- Tech List Start -->
                        <div class="product-category-list">
                            @forelse($categories as $category)
                                <a href="{{ route('product.by.category', $category->slug) }}" class="product-category-list__item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $category->name }}">
                                    <img src="{{ $category->icon ? asset($category->icon) : asset('frontend/assets/images/thumbs/tech-icon1.png') }}" alt="{{ $category->name }}">
                                </a>
                            @empty
                                <a href="javascript:void(0)" class="product-category-list__item">
                                    <img src="{{ asset('frontend/assets/images/thumbs/tech-icon1.png') }}" alt="">
                                </a>
                            @endforelse
                        </div>
                        <!-- Tech List End -->

                    </div>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="hero-thumb">

                    <img src="{{ $slider_data->first() ? asset($slider_data->first()->slider_image) : asset('frontend/assets/images/thumbs/banner-img.png') }}" alt="">
                    <img src="{{ asset('frontend/assets/images/shapes/dots.png') }}" alt="" class="dotted-img white-version">
                    <img src="{{ asset('frontend/assets/images/shapes/dots-white.png') }}" alt="" class="dotted-img dark-version">
                    <img src="{{ asset('frontend/assets/images/shapes/element2.png') }}" alt="" class="element two end-0">

                    <div class="statistics animation bg-main text-center">
                        <h5 class="statistics__amount text-white">{{ $total_subscribers ?? 0 }}+</h5>
                        <span class="statistics__text text-white font-14">Customers</span>
                    </div>

                    <div class="statistics style-two bg-white text-center">
                        <h5 class="statistics__amount statistics__amount-two text-heading">{{ $total_products ?? 0 }}+</h5>
                        <span class="statistics__text text-heading font-14">Themes & Plugins</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
