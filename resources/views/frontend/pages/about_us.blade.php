@extends('frontend.dashboard')
@section('frontend_title', 'About Us')
@section('frontend_contents')

    {{-- Breadcrumb Section --}}
    <section class="breadcrumb border-bottom p-0 d-block section-bg position-relative z-index-1">
        <div class="breadcrumb-two">
            <img src="{{ asset('frontend/assets/images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">
            <div class="container container-two">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="breadcrumb-two-content text-center">

                            <ul class="breadcrumb-list flx-align gap-2 mb-2 justify-content-center">
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <a href="{{ route('index') }}" class="breadcrumb-list__link text-body hover-text-main">Home</a>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__icon font-10"><i class="fas fa-chevron-right"></i></span>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__text">About Us</span>
                                </li>
                            </ul>
                            <h3 class="breadcrumb-two-content__title mb-0 text-capitalize">About Us</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Company Section --}}
    <section class="about-company padding-y-120 section-bg position-relative z-index-1 overflow-hidden">
        <img src="{{ asset('frontend/assets/images/gradients/banner-two-gradient.png') }}" alt="" class="bg--gradient">
        <div class="container container-two">
            <div class="row gy-5 align-items-center">

                <div class="col-lg-6">
                    <div class="about-company__image position-relative">
                        @if ($about_company && $about_company->about_image)
                            <img src="{{ asset('upload/about_image/' . $about_company->about_image) }}" alt="About Us" class="w-100 rounded-16">
                        @else
                            <img src="{{ asset('upload/no_image.jpg') }}" alt="About Us" class="w-100 rounded-16">
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="about-company__content">
                        <span class="section-subtitle mb-3 d-inline-block text-main font-14 fw-600 text-uppercase">Who We Are</span>
                        <h2 class="mb-24">About Nebstock</h2>

                        @if ($about_company && $about_company->about_description)
                            <div class="text-body">
                                {!! nl2br(e(strip_tags($about_company->about_description))) !!}
                            </div>
                        @else
                            <p class="text-body">Content coming soon.</p>
                        @endif

                        @if ($about_company && $about_company->about_youtube)
                            <div class="about-company__video mt-32 ratio ratio-16x9 rounded-16 overflow-hidden">
                                <iframe src="{{ $about_company->about_youtube }}" title="About Us Video" allowfullscreen></iframe>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Mission / Vision / Values Section --}}
    @if ($mission_vision->isNotEmpty())
        <section class="mission-vision position-relative z-index-1 padding-y-120">
            <div class="container container-two">
                <div class="row justify-content-center mb-40">
                    <div class="col-lg-7 text-center">
                        <span class="section-subtitle mb-3 d-inline-block text-main font-14 fw-600 text-uppercase">What Drives Us</span>
                        <h2 class="mb-0">Our Mission, Vision &amp; Values</h2>
                    </div>
                </div>

                <div class="row gy-4 justify-content-center">
                    @foreach ($mission_vision as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="mv-card h-100 p-32 rounded-16 border text-center" style=" padding: 35px; border-radius: 10px;">
                                <div class="mv-card__icon d-inline-flex align-items-center justify-content-center rounded-circle mb-24" style="width:64px;height:64px;background:rgba(var(--main-color-rgb, 184,134,11),0.1);">
                                    <i class="{{ $item->mission_vision_icon }} font-28 text-main"></i>
                                </div>
                                <h5 class="mb-12">{{ $item->mission_vision_title }}</h5>
                                <p class="text-body mb-0">{{ $item->mission_vision_description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection