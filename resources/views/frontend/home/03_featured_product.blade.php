<section class="product__section section--padding" style="background-color: #f8f9fa;">

    <div class="container">

        <div class="section__heading text-center mb-40">
            <h2 class="section__heading--maintitle">FEATURED PRODUCT</h2>
        </div>

        <div class="product__section--inner">

            <div class="row mb--n30">

                @foreach ($featured_products as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6 custom-col mb-30">
                        @include('frontend.partials.product_card', ['item' => $item])
                    </div>
                @endforeach

            </div>

            <div class="product__load--more text-center">
                
            </div>

        </div>

    </div>

</section>
