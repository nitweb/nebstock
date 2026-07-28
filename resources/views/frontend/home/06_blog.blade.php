<section class="blog__section section--padding">

    <div class="container">

        <div class="section__heading text-center mb-40">
            <h2 class="section__heading--maintitle">From The Blogs</h2>
        </div>

        <div class="blog__section--inner blog__swiper--activation swiper">

            <div class="swiper-wrapper">

                @foreach ($blogs as $blog)
                    <div class="swiper-slide">
                        <article class="blog__card">
                            <div class="blog__card--thumbnail">
                                <a class="blog__card--thumbnail__link" href="{{ route('blog.details', $blog->blog_slug) }}">
                                    <img class="blog__card--thumbnail__img" src="{{ asset('upload/blog_image/' . $blog->blog_image) }}" alt="{{ $blog->blog_title }}">
                                </a>
                            </div>
                            <div class="blog__card--content">
                                <div class="blog__meta d-flex">
                                    <span class="blog__meta--text meta__comment">{{ $blog->blogPublisher->name }}</span>
                                    <span class="blog__meta--text"> / </span>
                                    <span class="blog__meta--text meta__comment">{{ $blog->blogCategory->blog_category_name }}</span>
                                    <span class="blog__meta--text"> / </span>
                                    <span class="blog__meta--text meta__date">{{ \Carbon\Carbon::parse($blog->blog_published_date)->format('d M Y') }}</span>
                                </div>
                                <h3 class="blog__card--title"><a href="{{ route('blog.details', $blog->blog_slug) }}">{{ $blog->blog_title }}</a></h3>
                                <a class="blog__card--link" href="{{ route('blog.details', $blog->blog_slug) }}">Read More</a>
                            </div>
                        </article>
                    </div>
                @endforeach

            </div>

            <div class="swiper__nav--btn swiper-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" -chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>

            <div class="swiper__nav--btn swiper-button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" -chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </div>

        </div>

    </div>

</section>
