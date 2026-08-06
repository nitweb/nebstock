@extends('frontend.customer.dashboard')
@section('customer_title', 'Customer Dashboard')
@section('customer_contents')

    <!-- welcome balance Content Start -->
    <div class="welcome-balance mt-2 mb-40 flx-between gap-2">
        <div class="welcome-balance__left">
            <h4 class="welcome-balance__title mb-0">Welcome back! {{ $customer->name }}</h4>
        </div>
        <div class="welcome-balance__right flx-align gap-2">
            <span class="welcome-balance__text fw-500 text-heading">Account Status:</span>
            <h4 class="welcome-balance__balance mb-0 text-capitalize">{{ $customer->payment_status }}</h4>
        </div>
    </div>
    <!-- welcome balance Content End -->

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    <div class="dashboard-body__item-wrapper">

        <!-- dashboard body Item Start -->
        <div class="dashboard-body__item">

            <div class="row gy-4">

                <div class="col-xl-3 col-sm-6">
                    <div class="dashboard-widget">
                        <img src="{{ asset('frontend/assets/images/shapes/widget-shape1.png') }}" alt="" class="dashboard-widget__shape one">
                        <img src="{{ asset('frontend/assets/images/shapes/widget-shape2.png') }}" alt="" class="dashboard-widget__shape two">
                        <span class="dashboard-widget__icon">
                            <img src="{{ asset('frontend/assets/images/icons/dashboard-widget-icon1.svg') }}" alt="">
                        </span>
                        <div class="dashboard-widget__content flx-between gap-1 align-items-end">
                            <div>
                                <h4 class="dashboard-widget__number mb-1 mt-3">{{ $totalProducts }}</h4>
                                <span class="dashboard-widget__text font-14">Total Products</span>
                            </div>
                            <img src="{{ asset('frontend/assets/images/icons/chart-icon.svg') }}" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="dashboard-widget">
                        <img src="{{ asset('frontend/assets/images/shapes/widget-shape1.png') }}" alt="" class="dashboard-widget__shape one">
                        <img src="{{ asset('frontend/assets/images/shapes/widget-shape2.png') }}" alt="" class="dashboard-widget__shape two">
                        <span class="dashboard-widget__icon">
                            <img src="{{ asset('frontend/assets/images/icons/dashboard-widget-icon2.svg') }}" alt="">
                        </span>
                        <div class="dashboard-widget__content flx-between gap-1 align-items-end">
                            <div>
                                <h4 class="dashboard-widget__number mb-1 mt-3">{{ $remaining }}/{{ $limit }}</h4>
                                <span class="dashboard-widget__text font-14">Downloads Left Today</span>
                            </div>
                            <img src="{{ asset('frontend/assets/images/icons/chart-icon.svg') }}" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="dashboard-widget">
                        <img src="{{ asset('frontend/assets/images/shapes/widget-shape1.png') }}" alt="" class="dashboard-widget__shape one">
                        <img src="{{ asset('frontend/assets/images/shapes/widget-shape2.png') }}" alt="" class="dashboard-widget__shape two">
                        <span class="dashboard-widget__icon">
                            <img src="{{ asset('frontend/assets/images/icons/dashboard-widget-icon3.svg') }}" alt="">
                        </span>
                        <div class="dashboard-widget__content flx-between gap-1 align-items-end">
                            <div>
                                <h4 class="dashboard-widget__number mb-1 mt-3">{{ $totalDownloads }}</h4>
                                <span class="dashboard-widget__text font-14">Total Downloads</span>
                            </div>
                            <img src="{{ asset('frontend/assets/images/icons/chart-icon.svg') }}" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="dashboard-widget">
                        <img src="{{ asset('frontend/assets/images/shapes/widget-shape1.png') }}" alt="" class="dashboard-widget__shape one">
                        <img src="{{ asset('frontend/assets/images/shapes/widget-shape2.png') }}" alt="" class="dashboard-widget__shape two">
                        <span class="dashboard-widget__icon">
                            <img src="{{ asset('frontend/assets/images/icons/dashboard-widget-icon4.svg') }}" alt="">
                        </span>
                        <div class="dashboard-widget__content flx-between gap-1 align-items-end">
                            <div>
                                <h4 class="dashboard-widget__number mb-1 mt-3">{{ $customer->created_at->format('M Y') }}</h4>
                                <span class="dashboard-widget__text font-14">Member Since</span>
                            </div>
                            <img src="{{ asset('frontend/assets/images/icons/chart-icon.svg') }}" alt="">
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- dashboard body Item End -->

        <!-- dashboard body Item Start -->
        <div class="dashboard-body__item">

           <div class="row gy-4">

                <div class="col-12">
                    <div class="card common-card border border-gray-five">
                        <div class="card-body">
                            <div class="flx-between gap-2 mb-3">
                                <h6 class="mb-0">Recent Downloads</h6>
                                <a href="{{ route('customer.downloads') }}" class="link text-main font-14 fw-500">View All</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-body mt--24">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Product</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentDownloads as $download)
                                            <tr>
                                                <td data-label="SL">{{ $loop->iteration }}</td>
                                                <td data-label="Image">
                                                    <img src="{{ $download->product && $download->product->cover_image ? asset('upload/product_covers/' . $download->product->cover_image) : asset('frontend/assets/images/thumbs/product-img1.png') }}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                                </td>
                                                <td data-label="Date">{{ $download->created_at->format('d M Y, h:i A') }}</td>
                                                <td data-label="Product">{{ $download->product->name ?? 'Product removed' }}</td>
                                                <td data-label="Details">
                                                    @if($download->product)
                                                        <form action="{{ route('product.download', $download->product->slug) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-main"><i class="fas fa-download"></i></button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">No downloads yet. Head to the shop and grab something!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- dashboard body Item End -->


    </div>

@endsection
