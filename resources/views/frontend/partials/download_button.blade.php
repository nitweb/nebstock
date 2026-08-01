@php
    $__authUser = Auth::guard('user')->user();
    $__canDownload = $__authUser && $__authUser->role === 'customer' && $__authUser->payment_status === 'approved';
@endphp

@if($__canDownload)
    <form action="{{ route('product.download', $product->slug) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-outline-light btn-sm pill download-btn">
            <i class="fas fa-download me-1"></i> Download
        </button>
    </form>
@else
    {{-- Button hidden for guests / unapproved users, as required --}}
@endif
