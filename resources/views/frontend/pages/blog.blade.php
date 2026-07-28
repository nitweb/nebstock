@extends('frontend.dashboard')
@section('frontend_title', 'Blog')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Blog <span>& Article</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Blog</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Blog Section --}}
    <section class="blog__section section--padding">

        <div class="container">

            <div class="blog__section--inner">

                <div class="row mb--n30">

                    @foreach ($blog_list as $blog)
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-40">
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

                @if ($blog_list->lastPage() > 1)
                    <div class="pagination__area bg__gray--color">
                        <nav class="pagination justify-content-center">
                            <ul class="pagination__wrapper d-flex align-items-center justify-content-center">

                                {{-- Previous Arrow --}}
                                <li class="pagination__list">
                                    <a href="{{ $blog_list->previousPageUrl() ?? '#' }}" class="pagination__item--arrow link {{ $blog_list->onFirstPage() ? 'disabled' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400L100 256l144-144M120 256h292" />
                                        </svg>
                                        <span class="visually-hidden">page left arrow</span>
                                    </a>
                                </li>

                                {{-- Page Numbers --}}
                                @for ($i = 1; $i <= $blog_list->lastPage(); $i++)
                                    <li class="pagination__list">
                                        @if ($i == $blog_list->currentPage())
                                            <span class="pagination__item pagination__item--current">{{ $i }}</span>
                                        @else
                                            <a href="{{ $blog_list->url($i) }}" class="pagination__item link">{{ $i }}</a>
                                        @endif
                                    </li>
                                @endfor

                                {{-- Next Arrow --}}
                                <li class="pagination__list">
                                    <a href="{{ $blog_list->nextPageUrl() ?? '#' }}" class="pagination__item--arrow link {{ !$blog_list->hasMorePages() ? 'disabled' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M268 112l144 144-144 144M392 256H100" />
                                        </svg>
                                        <span class="visually-hidden">page right arrow</span>
                                    </a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                @endif

            </div>

        </div>

    </section>

@endsection
