@php
    $__authUser = Auth::guard('user')->user();
    $__canDownload = $__authUser && $__authUser->role === 'customer' && $__authUser->payment_status === 'approved';
@endphp

@if($__canDownload)
    <a href="{{ route('product.download', $product->slug) }}" class="btn btn-outline-light btn-sm pill download-btn">
        <i class="fas fa-download me-1"></i> Download
    </a>
@else
    {{-- Button hidden for guests / unapproved users, as required --}}
@endif
