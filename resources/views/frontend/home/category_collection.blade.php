{{-- style="background-color: {{ $loop->iteration % 2 != 0 ? '#f8f9fa' : '#ffffff' }};" --}}

<section class="product__section section--padding" style="background-color: {{ $loop->iteration % 2 == 0 ? '#f8f9fa' : '#ffffff' }};">

    <div class="container">

        <div class="section__heading text-center mb-40">
            <h2 class="section__heading--maintitle">{{ $cat->name }}</h2>
        </div>

        <div class="product__section--inner">

            <div class="row mb--n30">

                @foreach ($cat->products as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6 custom-col mb-30">
                        @include('frontend.partials.product_card', ['item' => $item])
                    </div>
                @endforeach

            </div>

            <div class="product__load--more text-center">
                <a class="load__more--btn primary__btn" href="{{ route('product.by.category', $cat->slug) }}">View All</a>
            </div>

        </div>

    </div>

</section>
