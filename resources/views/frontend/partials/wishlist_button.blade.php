@php
    $__isWishlisted = in_array($product->id, $wishlistedIds ?? []);
@endphp
<button type="button"
    class="product-item__wishlist {{ $__isWishlisted ? 'active' : '' }}"
    data-product-id="{{ $product->id }}"
    data-csrf="{{ csrf_token() }}"
    data-logged-in="{{ Auth::guard('user')->check() ? '1' : '0' }}"
    data-login-url="{{ route('customer.login') }}"
    data-toggle-url="{{ route('wishlist.toggle') }}"
    data-wishlist-toggle>
    <i class="fas fa-heart"></i>
</button>