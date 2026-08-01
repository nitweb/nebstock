<section class="popular padding-y-120 overflow-hidden">

    <div class="container container-two">

        <div class="section-heading style-left mb-64">
            <h5 class="section-heading__title">Popular Categories</h5>
        </div>

        <div class="popular-slider arrow-style-two row gy-4">

            @forelse($categories as $category)
                <div class="col-lg-2">
                    <a href="{{ route('product.by.category', $category->slug) }}" class="popular-item w-100">
                        <span class="popular-item__icon">
                            <img src="{{ $category->icon ? asset($category->icon) : asset('frontend/assets/images/icons/popular-icon1.svg') }}" alt="{{ $category->name }}">
                        </span>
                        <h6 class="popular-item__title font-18">{{ $category->name }}</h6>
                        <span class="popular-item__qty text-body">{{ $category->products->count() }}</span>
                    </a>
                </div>
            @empty
                <p class="text-center w-100">No categories available yet.</p>
            @endforelse

        </div>

        <div class="popular__button text-center">
            <a href="{{ route('shop') }}" class="font-18 fw-600 text-heading hover-text-main text-decoration-underline font-heading">Explore More</a>
        </div>

    </div>

</section>
