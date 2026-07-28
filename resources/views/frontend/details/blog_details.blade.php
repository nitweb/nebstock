@extends('frontend.dashboard')
@section('frontend_title', $blog_details->blog_title)
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">{{ $blog_details->blog_title }}</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Blog Details</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start blog details section -->
    <section class="blog__details--section section--padding">

        <div class="container">

            <div class="row">

                <div class="col-lg-8">

                    <div class="blog__details--wrapper">

                        <div class="entry__blog">

                            <div class="blog__post--header mb-30">
                                <h2 class="post__header--title mb-15">{{ $blog_details->blog_title }}</h2>
                                <p class="blog__post--meta">Posted by : {{ $blog_details->blogPublisher->name }} / On : {{ \Carbon\Carbon::parse($blog_details->blog_published_date)->format('d F Y') }} / In : <a class="blog__post--meta__link" href="javascript:void(0);">{{ $blog_details->blogCategory->blog_category_name ?? 'Uncategorized' }}</a></p>
                            </div>

                            <div class="blog__thumbnail mb-30">
                                <img class="blog__thumbnail--img border-radius-10" src="{{ asset('upload/blog_image/' . $blog_details->blog_image) }}" alt="{{ $blog_details->blog_title }}">
                            </div>

                            <div class="blog__details--content" style="text-align: justify;">
                                {!! $blog_details->blog_long_description !!}
                            </div>
                        </div>

                        <div class="blog__tags--social__media" style="margin-top:24px;">

                            @if ($blog_details->blog_tags)
                                <div style="display:flex; align-items:flex-start; gap:10px; flex-wrap:nowrap;">
                                    <label class="blog__tags--media__title" style="white-space:nowrap; padding-top:6px; flex-shrink:0; font-weight:600; font-size:14px; color:#555;">
                                        Related Tags :
                                    </label>
                                    <div style="display:flex; flex-wrap:wrap; gap:8px;">
                                        @foreach (explode(',', $blog_details->blog_tags) as $tag)
                                            @php $tag = trim($tag); @endphp
                                            @if ($tag)
                                                <a href="javascript:void(0)" style="display:inline-block; padding:5px 14px; background:#f5f5f5; border:1px solid #e0e0e0; border-radius:8px; font-size:13px; color:#444; white-space:nowrap; text-decoration:none; transition:all .2s;" onmouseover="this.style.background='#B8860B';this.style.color='#fff';this.style.borderColor='#B8860B';" onmouseout="this.style.background='#f5f5f5';this.style.color='#444';this.style.borderColor='#e0e0e0';">
                                                    #{{ $tag }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="blog__sidebar--widget left widget__area">

                        <div class="single__widget widget__search widget__bg">
                            <h2 class="widget__title h3">Search Objects</h2>
                            <form class="widget__search--form" onsubmit="return false;">
                                <label style="width:100%; position:relative;">
                                    <input id="blogSearchInput" class="widget__search--form__input" placeholder="Search..." type="text" autocomplete="off">
                                </label>
                                <button class="widget__search--form__btn" type="button" onclick="doBlogSearch()" aria-label="search button">
                                    <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                    </svg>
                                </button>
                            </form>
                            {{-- Search Results Dropdown --}}
                            <div id="blogSearchResults" style="display:none; margin-top:10px;"></div>
                        </div>

                        <div class="single__widget widget__bg">
                            <h2 class="widget__title h3">Recent Posts</h2>
                            <div class="widget__post--article">
                                @foreach ($recent_blogs as $recent)
                                    <div class="post__article--items d-flex align-items-center">
                                        <div class="post__article--thumbnail">
                                            <a class="display-block" href="{{ route('blog.details', $recent->blog_slug) }}">
                                                <img class="post__article--thumbnail__img" src="{{ asset('upload/blog_image/' . $recent->blog_image) }}" alt="{{ $recent->blog_title }}">
                                            </a>
                                        </div>
                                        <div class="post__article--content">
                                            <h3 class="post__article--content__title"><a href="{{ route('blog.details', $recent->blog_slug) }}">{{ $recent->blog_title }} </a></h3>
                                            <span class="meta__deta">{{ \Carbon\Carbon::parse($recent->blog_published_date)->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
    <!-- End blog details section -->

    <script>
        const blogSearchUrl = "{{ route('blog.search') }}"; // এটা আগে define করো

        const searchInput = document.getElementById('blogSearchInput');
        const resultsBox = document.getElementById('blogSearchResults');
        let searchTimer;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(doBlogSearch, 400);
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('#blogSearchInput') && !e.target.closest('#blogSearchResults')) {
                resultsBox.style.display = 'none';
            }
        });

        function doBlogSearch() {
            const q = searchInput.value.trim();
            if (q.length < 2) {
                resultsBox.style.display = 'none';
                return;
            }

            resultsBox.innerHTML = '<p style="padding:10px; color:#888;">Searching...</p>';
            resultsBox.style.display = 'block';

            fetch(blogSearchUrl + '?q=' + encodeURIComponent(q), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('HTTP error: ' + res.status);
                    return res.json();
                })
                .then(data => {
                    if (data.length === 0) {
                        resultsBox.innerHTML = '<p style="padding:10px; color:#888;">No results found.</p>';
                        return;
                    }

                    let html = '<div style="display:flex; flex-direction:column; gap:10px; padding:5px 0;">';
                    data.forEach(blog => {
                        html += `
                    <a href="${blog.url}" style="display:flex; align-items:center; gap:10px; text-decoration:none; color:inherit; padding:8px; border-radius:6px; background:#f9f9f9; transition:background 0.2s;"
                       onmouseover="this.style.background='#f0f0f0'" onmouseout="this.style.background='#f9f9f9'">
                        <img src="${blog.image}" alt="${blog.title}"
                             style="width:60px; height:50px; object-fit:cover; border-radius:4px; flex-shrink:0;">
                        <div>
                            <p style="margin:0; font-size:13px; font-weight:600; line-height:1.3;">${blog.title}</p>
                            <span style="font-size:11px; color:#888;">${blog.date}</span>
                        </div>
                    </a>`;
                    });
                    html += '</div>';
                    resultsBox.innerHTML = html;
                })
                .catch(err => {
                    console.error('Search error:', err);
                    resultsBox.innerHTML = '<p style="padding:10px; color:red;">Error: ' + err.message + '</p>';
                });
        }
    </script>

@endsection
