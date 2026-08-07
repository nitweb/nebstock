{{-- Usage: @include('frontend.partials.page_breadcrumb', ['pageTitle' => 'Terms & Conditions']) --}}
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
                                <span class="breadcrumb-list__text">{{ $pageTitle }}</span>
                            </li>
                        </ul>
                        <h3 class="breadcrumb-two-content__title mb-0 text-capitalize">{{ $pageTitle }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
