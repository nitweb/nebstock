@extends('frontend.dashboard')
@section('frontend_title', 'My Dashboard')
@section('frontend_contents')

    <section class="padding-y-120">
        <div class="container container-two">

            <div class="section-heading style-left flx-between gap-3 mb-48">
                <div>
                    <h3 class="section-heading__title mb-2">Welcome, {{ $customer->name }}</h3>
                    <p class="section-heading__desc font-16 mb-0">All items are unlocked for your account.</p>
                </div>
                <div class="text-end">
                    <span class="d-block font-14 text-body">Downloads left today</span>
                    <h4 class="mb-0">{{ $remaining }} / {{ \App\Http\Controllers\DownloadController::DAILY_LIMIT }}</h4>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mb-4">{{ session('error') }}</div>
            @endif

            <div class="row gy-4 card-wrapper">
                @forelse($products as $product)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="product-item box-shadow">
                            <div class="product-item__thumb d-flex">
                                <img src="{{ $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('frontend/assets/images/thumbs/product-img9.png') }}" alt="{{ $product->name }}" class="cover-img">
                            </div>
                            <div class="product-item__content">
                                <h6 class="product-item__title mb-3">{{ $product->name }}</h6>
                                <div class="product-item__bottom">
                                    @include('frontend.partials.download_button', ['product' => $product])
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center w-100">No products available yet.</p>
                @endforelse
            </div>

            <div class="mt-48">
                {{ $products->links() }}
            </div>

        </div>
    </section>

@endsection
