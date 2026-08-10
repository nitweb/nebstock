@extends('frontend.customer.dashboard')
@section('customer_title', 'My Wishlist')
@section('customer_contents')

    <div class="dashboard-body__content">
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif
        <div class="row gy-4">
            <div class="col-12">
                <div class="flx-between gap-2 mb-3">
                    <h6 class="mb-0">My Wishlist</h6>
                </div>
                <div class="card common-card border border-gray-five">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-body mt--24">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($wishlist as $item)
                                        <tr>
                                            <td data-label="SL">{{ $wishlist->firstItem() + $loop->index }}</td>
                                            <td data-label="Image">
                                                <img src="{{ $item->product && $item->product->cover_image ? asset('upload/product_covers/' . $item->product->cover_image) : asset('frontend/assets/images/thumbs/product-img1.png') }}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                            </td>
                                            <td data-label="Product">{{ $item->product->name ?? 'Product removed' }}</td>
                                            <td data-label="Category">
                                                @if($item->product && $item->product->categories->count())
                                                    {{ $item->product->categories->first()->name }}
                                                @endif
                                            </td>
                                            <td data-label="Action">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if($item->product)
                                                        @include('frontend.partials.download_button', ['product' => $item->product])
                                                    @endif
                                                    <a href="{{ route('wishlist.remove', $item->id) }}" class="btn btn-outline-danger btn-sm pill" onclick="return confirm('Remove from wishlist?')">
                                                        <i class="fas fa-trash me-1"></i> Remove
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">Your wishlist is empty. Browse the <a href="{{ route('shop') }}">shop</a> and tap the heart icon to save products here.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="flx-between gap-2 flex-wrap">
                                <span class="paginate-content__text fs-14">
                                    Showing {{ $wishlist->firstItem() ?? 0 }} - {{ $wishlist->lastItem() ?? 0 }} of {{ $wishlist->total() }}
                                </span>
                                @include('frontend.customer.pages.partials.pagination', ['paginator' => $wishlist])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection