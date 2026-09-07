@extends('frontend.dashboard')
@section('frontend_title', $font->name)
@section('frontend_contents')

    <style>
        @font-face {
            font-family: "font-preview-{{ $font->id }}";
            src: url('{{ $font->font_file_url }}');
            font-display: swap;
        }
    </style>

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
                                    <a href="{{ route('fonts.index') }}" class="breadcrumb-list__link text-body hover-text-main">Fonts</a>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__icon font-10"><i class="fas fa-chevron-right"></i></span>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">{{ $font->name }}</li>
                            </ul>
                            <h1 class="breadcrumb-two-content__title mb-0">{{ $font->name }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container container-two">
            <div class="row g-4">

                <div class="col-lg-8">
                    {{-- Live, editable preview — type anything to test the font --}}
                    <div class="border rounded p-4 mb-4">
                        <input
                            type="text"
                            id="previewText"
                            class="form-control border-0 p-0"
                            value="The Quick Brown Fox Jumps Over The Lazy Dog"
                            style="font-family:'font-preview-{{ $font->id }}', sans-serif; font-size: 48px; box-shadow:none;"
                        >
                    </div>
                    <small class="text-muted">Type above to preview your own text in this font.</small>

                    @if ($font->description)
                        <h5 class="mt-4">About this font</h5>
                        <p>{{ $font->description }}</p>
                    @endif
                    @if ($font->designer)
                        <p class="text-muted mb-0">Designed by {{ $font->designer }}</p>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="border rounded p-4">
                        <h4 class="mb-3">{{ $font->name }}</h4>
                        <p class="text-muted mb-4">{{ $font->downloads_count }} downloads</p>

                        @php
                            $__authUser = Auth::guard('user')->user();
                            $__canDownloadFonts = $__authUser && $__authUser->role === 'customer' && $__authUser->payment_status === 'approved';
                        @endphp

                        @if ($__canDownloadFonts)
                            <a href="{{ route('fonts.download', $font->slug) }}" class="btn btn-main pill w-100">
                                <i class="fas fa-download me-1"></i> Download Font
                            </a>
                        @elseif ($__authUser)
                            <a href="{{ route('customer.payment') }}" class="btn btn-main pill w-100">
                                <i class="fas fa-lock me-1"></i> Complete Payment to Unlock
                            </a>
                        @else
                            <a href="{{ route('customer.login') }}" class="btn btn-outline-main pill w-100">
                                <i class="fas fa-lock me-1"></i> Login to Download
                            </a>
                        @endif
                    </div>
                </div>

            </div>

            @if ($relatedFonts->count())
                <div class="mt-5">
                    <h4 class="mb-3">More Fonts</h4>
                    <div class="row g-4">
                        @foreach ($relatedFonts as $related)
                            <div class="col-md-6 col-xl-3">
                                <a href="{{ route('fonts.show', $related->slug) }}" class="text-decoration-none text-dark">
                                    <div class="border rounded p-3 h-100">
                                        <strong>{{ $related->name }}</strong>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <script>
        // Live preview: reflect typed text without page reload
        document.getElementById('previewText')?.addEventListener('input', function() {
            // input value updates itself; nothing extra needed since it's a live text input
        });
    </script>

@endsection