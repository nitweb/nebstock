<section class="banner__section section--padding">

    <div class="container">

        <div class="row mb--n30">

            <div class="col-lg-8  mb-30">
                <div class="banner__box border-radius-5 position-relative">
                    <a class="display-block" href="{{ route('product.by.category', 'clothing') }}">
                        <img class="banner__box--thumbnail banner_sm_height-250 border-radius-5" src="{{ asset('upload/static_images/category_cover_01.jpg') }}" alt="banner-img" style="height: 490px;">
                    </a>
                </div>
            </div>

            <div class="col-lg-4 mb-30">

                <div class="banner__box--right__sidebar">

                    <div class="banner__box border-radius-5 position-relative mb-30">
                        <a class="display-block" href="{{ route('product.by.category', 'hats') }}">
                            <img class="banner__box--thumbnail border-radius-5" src="{{ asset('upload/static_images/category_cover_02.jpeg') }}" alt="banner-img">
                        </a>
                    </div>

                    <div class="banner__box border-radius-5 position-relative">
                        <a class="display-block" href="{{ route('product.by.category', 'books') }}">
                            <img class="banner__box--thumbnail border-radius-5" src="{{ asset('upload/static_images/category_cover_03.jpeg') }}" alt="banner-img">
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
