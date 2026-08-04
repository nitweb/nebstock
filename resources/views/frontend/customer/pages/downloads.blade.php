@extends('frontend.customer.dashboard')
@section('customer_title', 'Customer Downloads')
@section('customer_contents')

    <div class="dashboard-body__content">
        <!-- ========================= Statement section start =========================== -->
        <div class="row gy-4">
            <div class="col-12">
                <div class="flx-between gap-2 mb-3">
                    <h6 class="mb-0">Download History</h6>
                    <span class="badge bg-main-two text-main">{{ $remaining }}/{{ $limit }} left today</span>
                </div>
                <div class="card common-card border border-gray-five">
                    <div class="card-body">
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
                                    @forelse($downloads as $download)
                                        <tr>
                                            <td data-label="SL">{{ $downloads->firstItem() + $loop->index }}</td>
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
                                            <td colspan="5" class="text-center py-4">You haven't downloaded anything yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="flx-between gap-2">
                                <span class="paginate-content__text fs-14">
                                    Showing {{ $downloads->firstItem() ?? 0 }} - {{ $downloads->lastItem() ?? 0 }} of {{ $downloads->total() }}
                                </span>
                                {{ $downloads->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========================= Statement section End =========================== -->

    </div>

@endsection
