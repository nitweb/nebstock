@extends('frontend.dashboard')
@section('frontend_title', 'About Us')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">About Us</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">About</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ════ ABOUT SECTION ════ --}}
    <section class="about__section" style="padding: 80px 0;">
        <div class="container">
            <div class="row align-items-center g-5">

                {{-- Image --}}
                <div class="col-lg-5">
                    <div style="position: relative; display: inline-block; width: 100%;">
                        <img src="{{ !empty($about_company->about_image) ? url('upload/about_image/' . $about_company->about_image) : url('upload/no_image.jpg') }}" alt="About Us" style="width: 100%; border-radius: 4px; object-fit: cover; display: block;">
                        {{-- Gold accent block --}}
                        <div style="position: absolute; bottom: -16px; right: -16px; width: 72px; height: 72px; background: var(--secondary-color); border-radius: 4px; z-index: -1;"></div>
                    </div>
                </div>

                {{-- Text --}}
                <div class="col-lg-6 offset-lg-1">
                    <p style="font-size: 12px; font-weight: 600; letter-spacing: 3px; color: var(--secondary-color); text-transform: uppercase; margin-bottom: 10px;">Who We Are</p>
                    <h2 style="font-size: 34px; font-weight: 700; color: var(--foreground-color); line-height: 1.25; margin-bottom: 16px;">
                        About Nicole Murray
                    </h2>
                    <div style="width: 48px; height: 3px; background: var(--secondary-color); margin-bottom: 24px;"></div>
                    <div style="font-size: 15px; line-height: 1.9; color: var(--body-text-color); text-align: justify;">
                        {!! $about_company->about_description !!}
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ════ COUNTER BANNER ════ --}}
    <div style="background: var(--bg-black-color); padding: 64px 0;">
        <div class="container">
            <div class="row g-0 text-center">

                <div class="col-6 col-md-3" style="border-right: 1px solid rgba(255,255,255,0.08); padding: 20px;">
                    <div style="font-size: 52px; font-weight: 700; color: var(--secondary-color); line-height: 1; font-family: var(--frank-ruhl-fonts);">
                        <span class="js-counter" data-count="50">0</span>+
                    </div>
                    <p style="font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-top: 10px; line-height: 1.7;">Years of<br>Foundation</p>
                </div>

                <div class="col-6 col-md-3" style="border-right: 1px solid rgba(255,255,255,0.08); padding: 20px;">
                    <div style="font-size: 52px; font-weight: 700; color: var(--secondary-color); line-height: 1; font-family: var(--frank-ruhl-fonts);">
                        <span class="js-counter" data-count="100">0</span>+
                    </div>
                    <p style="font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-top: 10px; line-height: 1.7;">Skilled Team<br>Members</p>
                </div>

                <div class="col-6 col-md-3" style="border-right: 1px solid rgba(255,255,255,0.08); padding: 20px;">
                    <div style="font-size: 52px; font-weight: 700; color: var(--secondary-color); line-height: 1; font-family: var(--frank-ruhl-fonts);">
                        <span class="js-counter" data-count="80">0</span>k+
                    </div>
                    <p style="font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-top: 10px; line-height: 1.7;">Happy<br>Customers</p>
                </div>

                <div class="col-6 col-md-3" style="padding: 20px;">
                    <div style="font-size: 52px; font-weight: 700; color: var(--secondary-color); line-height: 1; font-family: var(--frank-ruhl-fonts);">
                        <span class="js-counter" data-count="70">0</span>+
                    </div>
                    <p style="font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-top: 10px; line-height: 1.7;">Monthly<br>Orders</p>
                </div>

            </div>
        </div>
    </div>

    {{-- ════ MISSION / VISION / VALUES ════ --}}
    <section style="background: var(--bg-gray-color); padding: 80px 0;">
        <div class="container">

            {{-- Section Heading --}}
            <div class="text-center mb-5">
                <p style="font-size: 12px; font-weight: 600; letter-spacing: 3px; color: var(--secondary-color); text-transform: uppercase; margin-bottom: 10px;">What Drives Us</p>
                <h2 style="font-size: 30px; font-weight: 700; color: var(--foreground-color);">Our Mission, Vision &amp; Values</h2>
            </div>

            {{-- Cards --}}
            <div class="row g-4">

                {{-- @foreach ($mission_vision as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="mvv-card" style="background: #fff; border: 1px solid var(--border-color); border-radius: 6px; padding: 36px 28px; position: relative; overflow: hidden; transition: transform .25s ease, box-shadow .25s ease; height: 100%;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--secondary-color);"></div>
                        <i class="{{ $item->mission_vision_icon }}" style="font-size: 50px;margin-bottom: 30px;"></i>
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--foreground-color); margin-bottom: 12px;">{{ $item->mission_vision_title }}</h3>
                        <p style="font-size: 14px; line-height: 1.85; color: var(--foreground-sub-color); margin: 0;">
                            {{ $item->mission_vision_description }}
                        </p>
                        <span style="position: absolute; bottom: 12px; right: 20px; font-size: 60px; font-weight: 700; color: rgba(184,134,11,0.06); line-height: 1; font-family: var(--frank-ruhl-fonts); user-select: none; pointer-events: none;">01</span>
                    </div>
                </div>
                @endforeach --}}

                {{-- Mission --}}
                <div class="col-lg-4 col-md-6">
                    <div class="mvv-card" style="background: #fff; border: 1px solid var(--border-color); border-radius: 6px; padding: 36px 28px; position: relative; overflow: hidden; transition: transform .25s ease, box-shadow .25s ease; height: 100%;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--secondary-color);"></div>
                        <div style="width: 52px; height: 52px; background: rgba(184,134,11,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="var(--secondary-color)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <circle cx="12" cy="12" r="6" />
                                <circle cx="12" cy="12" r="2" />
                            </svg>
                        </div>
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--foreground-color); margin-bottom: 12px;">Our Mission</h3>
                        <p style="font-size: 14px; line-height: 1.85; color: var(--foreground-sub-color); margin: 0; text-align: justify;">
                            Our mission is to provide stylish, high-quality clothing, hats, and books that inspire confidence, creativity, and comfort in everyday life while delivering a smooth and enjoyable shopping experience for customers worldwide.
                        </p>
                        <span style="position: absolute; bottom: 12px; right: 20px; font-size: 60px; font-weight: 700; color: rgba(184,134,11,0.06); line-height: 1; font-family: var(--frank-ruhl-fonts); user-select: none; pointer-events: none;">01</span>
                    </div>
                </div>

                {{-- Vision --}}
                <div class="col-lg-4 col-md-6">
                    <div class="mvv-card" style="background: #fff; border: 1px solid var(--border-color); border-radius: 6px; padding: 36px 28px; position: relative; overflow: hidden; transition: transform .25s ease, box-shadow .25s ease; height: 100%;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--secondary-color);"></div>
                        <div style="width: 52px; height: 52px; background: rgba(184,134,11,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="var(--secondary-color)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </div>
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--foreground-color); margin-bottom: 12px;">Our Vision</h3>
                        <p style="font-size: 14px; line-height: 1.85; color: var(--foreground-sub-color); margin: 0; text-align: justify;">
                            Our vision is to become a trusted global eCommerce brand recognized for modern fashion, inspiring lifestyle products, excellent customer service, and a commitment to quality and innovation.
                        </p>
                        <span style="position: absolute; bottom: 12px; right: 20px; font-size: 60px; font-weight: 700; color: rgba(184,134,11,0.06); line-height: 1; font-family: var(--frank-ruhl-fonts); user-select: none; pointer-events: none;">02</span>
                    </div>
                </div>

                {{-- Values --}}
                <div class="col-lg-4 col-md-6">
                    <div class="mvv-card" style="background: #fff; border: 1px solid var(--border-color); border-radius: 6px; padding: 36px 28px; position: relative; overflow: hidden; transition: transform .25s ease, box-shadow .25s ease; height: 100%;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--secondary-color);"></div>
                        <div style="width: 52px; height: 52px; background: rgba(184,134,11,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="var(--secondary-color)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <polygon points="6 3 18 3 22 9 12 22 2 9" />
                                <path d="M2 9h20M6 3l6 19M18 3l-6 19" />
                            </svg>
                        </div>
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--foreground-color); margin-bottom: 12px;">Our Values</h3>
                        <p style="font-size: 14px; line-height: 1.85; color: var(--foreground-sub-color); margin: 0; text-align: justify;">
                            We value quality, authenticity, creativity, and customer satisfaction. We believe in offering products that combine style, comfort, and inspiration while building lasting relationships with customers through trust, reliability, and exceptional service.
                        </p>
                        <span style="position: absolute; bottom: 12px; right: 20px; font-size: 60px; font-weight: 700; color: rgba(184,134,11,0.06); line-height: 1; font-family: var(--frank-ruhl-fonts); user-select: none; pointer-events: none;">03</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ════ COUNTER ANIMATION + HOVER SCRIPT ════ --}}
    <style>
        .mvv-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.09);
        }
    </style>

    <script>
        (function() {
            const counters = document.querySelectorAll('.js-counter');
            const animateCounter = (el) => {
                const target = parseInt(el.getAttribute('data-count'));
                const duration = 2000;
                const stepTime = 16;
                const steps = Math.ceil(duration / stepTime);
                let current = 0;
                const increment = Math.ceil(target / steps);
                const timer = setInterval(() => {
                    current = Math.min(current + increment, target);
                    el.textContent = current;
                    if (current >= target) clearInterval(timer);
                }, stepTime);
            };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.4
            });
            counters.forEach(c => observer.observe(c));
        })();
    </script>

@endsection
