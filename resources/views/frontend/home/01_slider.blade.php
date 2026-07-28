<section class="hero__slider--section">

    <div class="hero__slider--activation swiper">

        <div class="swiper-wrapper">

            @foreach ($slider_data as $item)
                <div class="swiper-slide">
                    <div class="hero__slider--items" style="padding: 0;">
                        <img src="{{ !empty($item->slider_image) ? url('upload/slider_image/' . $item->slider_image) : url('upload/no_image.jpg') }}" alt="Slider Image" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                </div>
            @endforeach

        </div>

    </div>

</section>
