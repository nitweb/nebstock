@extends('frontend.dashboard')
@section('frontend_title', 'Contact Us')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Contact Us</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Contact</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Contact Section --}}
    <section class="contact__section section--padding">

        <div class="container">

            <div class="contact__section--heading text-center mb-40">
                <h2 class="contact__section--heading__maintitle">Get In Touch</h2>
                <p class="contact__section--heading__desc">We are open for any suggestion or just to have a chat</p>
            </div>

            <div class="main__contact--area position__relative">

                <div class="contact__form">

                    <h3 class="contact__form--title mb-30">Contact Me</h3>

                    {{-- Contact Toast --}}
                    <div id="contact__toast" style="display:none; position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 260px; padding: 14px 18px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.25); align-items: center; gap: 12px;">
                        <span id="contact__toast--icon" style="width:34px;height:34px;flex-shrink:0;border-radius:50%;border:2px solid rgba(255,255,255,.35);display:flex;align-items:center;justify-content:center;">
                            <svg id="contact__toast--svg" viewBox="0 0 24 24" width="16" height="16" xmlns="http://www.w3.org/2000/svg"></svg>
                        </span>
                        <div>
                            <p id="contact__toast--title" style="margin:0;font-weight:500;color:#fff;font-size:13px;"></p>
                            <p id="contact__toast--message" style="margin:2px 0 0;color:rgba(255,255,255,.75);font-size:12px;"></p>
                        </div>
                    </div>

                    <form class="contact__form--inner" action="{{ route('contact.submit') }}" method="POST">

                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="contact__form--list mb-20">
                                    <label class="contact__form--label" for="input1">
                                        Name <span class="contact__form--label__star">*</span>
                                    </label>
                                    <input class="contact__form--input" name="contact_form_name" value="{{ old('contact_form_name') }}" id="input1" placeholder="Enter your name" type="text" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="contact__form--list mb-20">
                                    <label class="contact__form--label" for="input2">
                                        Email <span class="contact__form--label__star">*</span>
                                    </label>
                                    <input class="contact__form--input" name="contact_form_email" value="{{ old('contact_form_email') }}" id="input2" placeholder="Enter your email" type="email" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="contact__form--list mb-20">
                                    <label class="contact__form--label" for="input3">
                                        Phone <span style="font-weight: 400;">(Optional)</span>
                                    </label>
                                    <input class="contact__form--input" name="contact_form_phone" value="{{ old('contact_form_phone') }}" id="input3" placeholder="Enter your phone number" type="text">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="contact__form--list mb-20">
                                    <label class="contact__form--label" for="input4">
                                        Subject <span class="contact__form--label__star">*</span>
                                    </label>
                                    <input class="contact__form--input" name="contact_form_subject" value="{{ old('contact_form_subject') }}" id="input4" placeholder="Enter subject" type="text" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="contact__form--list mb-15">
                                    <label class="contact__form--label" for="input5">
                                        Message <span class="contact__form--label__star">*</span>
                                    </label>
                                    <textarea class="contact__form--textarea" name="contact_form_message" id="input5" placeholder="Write your message" required>{{ old('contact_form_message') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button class="contact__form--btn primary__btn" type="submit">
                            <span>Send Message</span>
                        </button>

                    </form>

                </div>

                <div class="contact__info border-radius-5">
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">Contact Us</h3>
                        <div class="contact__info--items__inner d-flex">
                            <div class="contact__info--icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31.568" height="31.128" viewBox="0 0 31.568 31.128">
                                    <path id="ic_phone_forwarded_24px" d="M26.676,16.564l7.892-7.782L26.676,1V5.669H20.362v6.226h6.314Zm3.157,7a18.162,18.162,0,0,1-5.635-.887,1.627,1.627,0,0,0-1.61.374l-3.472,3.424a23.585,23.585,0,0,1-10.4-10.257l3.472-3.44a1.48,1.48,0,0,0,.395-1.556,17.457,17.457,0,0,1-.9-5.556A1.572,1.572,0,0,0,10.1,4.113H4.578A1.572,1.572,0,0,0,3,5.669,26.645,26.645,0,0,0,29.832,32.128a1.572,1.572,0,0,0,1.578-1.556V25.124A1.572,1.572,0,0,0,29.832,23.568Z" transform="translate(-3 -1)" fill="currentColor" />
                                </svg>
                            </div>
                            <div class="contact__info--content">
                                <p class="contact__info--content__desc text-white">Change the design through a range <br> <a href="tel:{{ GlobalSiteSettings()->site_phone }}">{{ GlobalSiteSettings()->site_phone }}</a> <a href="tel:{{ GlobalSiteSettings()->site_phone_alt }}">{{ GlobalSiteSettings()->site_phone_alt }}</a> </p>
                            </div>
                        </div>
                    </div>
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">Email Address</h3>
                        <div class="contact__info--items__inner d-flex">
                            <div class="contact__info--icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31.57" height="31.13" viewBox="0 0 31.57 31.13">
                                    <path id="ic_email_24px" d="M30.413,4H5.157C3.421,4,2.016,5.751,2.016,7.891L2,31.239c0,2.14,1.421,3.891,3.157,3.891H30.413c1.736,0,3.157-1.751,3.157-3.891V7.891C33.57,5.751,32.149,4,30.413,4Zm0,7.783L17.785,21.511,5.157,11.783V7.891l12.628,9.728L30.413,7.891Z" transform="translate(-2 -4)" fill="currentColor" />
                                </svg>
                            </div>
                            <div class="contact__info--content">
                                <p class="contact__info--content__desc text-white"> <a href="{{ GlobalSiteSettings()->site_email }}">{{ GlobalSiteSettings()->site_email }}</a> <br> <a href="{{ GlobalSiteSettings()->site_email_alt }}">{{ GlobalSiteSettings()->site_email_alt }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">Office Location</h3>
                        <div class="contact__info--items__inner d-flex">
                            <div class="contact__info--icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31.57" height="31.13" viewBox="0 0 31.57 31.13">
                                    <path id="ic_account_balance_24px" d="M5.323,14.341V24.718h4.985V14.341Zm9.969,0V24.718h4.985V14.341ZM2,32.13H33.57V27.683H2ZM25.262,14.341V24.718h4.985V14.341ZM17.785,1,2,8.412v2.965H33.57V8.412Z" transform="translate(-2 -1)" fill="currentColor" />
                                </svg>
                            </div>
                            <div class="contact__info--content">
                                <p class="contact__info--content__desc text-white"> {!! GlobalSiteSettings()->site_address !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">Follow Us</h3>
                        <ul class="contact__info--social d-flex">
                            <li class="contact__info--social__list">
                                <a class="contact__info--social__icon" target="_blank" href="https://www.facebook.com/">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="7.667" height="16.524" viewBox="0 0 7.667 16.524">
                                        <path data-name="Path 237" d="M967.495,353.678h-2.3v8.253h-3.437v-8.253H960.13V350.77h1.624v-1.888a4.087,4.087,0,0,1,.264-1.492,2.9,2.9,0,0,1,1.039-1.379,3.626,3.626,0,0,1,2.153-.6l2.549.019v2.833h-1.851a.732.732,0,0,0-.472.151.8.8,0,0,0-.246.642v1.719H967.8Z" transform="translate(-960.13 -345.407)" fill="currentColor"></path>
                                    </svg>
                                    <span class="visually-hidden">Facebook</span>
                                </a>
                            </li>
                            <li class="contact__info--social__list">
                                <a class="contact__info--social__icon" target="_blank" href="https://twitter.com/">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16.489" height="13.384" viewBox="0 0 16.489 13.384">
                                        <path data-name="Path 303" d="M966.025,1144.2v.433a9.783,9.783,0,0,1-.621,3.388,10.1,10.1,0,0,1-1.845,3.087,9.153,9.153,0,0,1-3.012,2.259,9.825,9.825,0,0,1-4.122.866,9.632,9.632,0,0,1-2.748-.4,9.346,9.346,0,0,1-2.447-1.11q.4.038.809.038a6.723,6.723,0,0,0,2.24-.376,7.022,7.022,0,0,0,1.958-1.054,3.379,3.379,0,0,1-1.958-.687,3.259,3.259,0,0,1-1.186-1.666,3.364,3.364,0,0,0,.621.056,3.488,3.488,0,0,0,.885-.113,3.267,3.267,0,0,1-1.374-.631,3.356,3.356,0,0,1-.969-1.186,3.524,3.524,0,0,1-.367-1.5v-.057a3.172,3.172,0,0,0,1.544.433,3.407,3.407,0,0,1-1.1-1.214,3.308,3.308,0,0,1-.4-1.609,3.362,3.362,0,0,1,.452-1.694,9.652,9.652,0,0,0,6.964,3.538,3.911,3.911,0,0,1-.075-.772,3.293,3.293,0,0,1,.452-1.694,3.409,3.409,0,0,1,1.233-1.233,3.257,3.257,0,0,1,1.685-.461,3.351,3.351,0,0,1,2.466,1.073,6.572,6.572,0,0,0,2.146-.828,3.272,3.272,0,0,1-.574,1.083,3.477,3.477,0,0,1-.913.8,6.869,6.869,0,0,0,1.958-.546A7.074,7.074,0,0,1,966.025,1144.2Z" transform="translate(-951.23 -1140.849)" fill="currentColor"></path>
                                    </svg>
                                    <span class="visually-hidden">Twitter</span>
                                </a>
                            </li>
                            <li class="contact__info--social__list">
                                <a class="contact__info--social__icon" target="_blank" href="https://www.instagram.com/">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16.497" height="16.492" viewBox="0 0 19.497 19.492">
                                        <path data-name="Icon awesome-instagram" d="M9.747,6.24a5,5,0,1,0,5,5A4.99,4.99,0,0,0,9.747,6.24Zm0,8.247A3.249,3.249,0,1,1,13,11.238a3.255,3.255,0,0,1-3.249,3.249Zm6.368-8.451A1.166,1.166,0,1,1,14.949,4.87,1.163,1.163,0,0,1,16.115,6.036Zm3.31,1.183A5.769,5.769,0,0,0,17.85,3.135,5.807,5.807,0,0,0,13.766,1.56c-1.609-.091-6.433-.091-8.042,0A5.8,5.8,0,0,0,1.64,3.13,5.788,5.788,0,0,0,.065,7.215c-.091,1.609-.091,6.433,0,8.042A5.769,5.769,0,0,0,1.64,19.341a5.814,5.814,0,0,0,4.084,1.575c1.609.091,6.433.091,8.042,0a5.769,5.769,0,0,0,4.084-1.575,5.807,5.807,0,0,0,1.575-4.084c.091-1.609.091-6.429,0-8.038Zm-2.079,9.765a3.289,3.289,0,0,1-1.853,1.853c-1.283.509-4.328.391-5.746.391S5.28,19.341,4,18.837a3.289,3.289,0,0,1-1.853-1.853c-.509-1.283-.391-4.328-.391-5.746s-.113-4.467.391-5.746A3.289,3.289,0,0,1,4,3.639c1.283-.509,4.328-.391,5.746-.391s4.467-.113,5.746.391a3.289,3.289,0,0,1,1.853,1.853c.509,1.283.391,4.328.391,5.746S17.855,15.705,17.346,16.984Z" transform="translate(0.004 -1.492)" fill="currentColor"></path>
                                    </svg>
                                    <span class="visually-hidden">Instagram</span>
                                </a>
                            </li>
                            <li class="contact__info--social__list">
                                <a class="contact__info--social__icon" target="_blank" href="https://www.youtube.com/">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16.49" height="11.582" viewBox="0 0 16.49 11.582">
                                        <path data-name="Path 321" d="M967.759,1365.592q0,1.377-.019,1.717-.076,1.114-.151,1.622a3.981,3.981,0,0,1-.245.925,1.847,1.847,0,0,1-.453.717,2.171,2.171,0,0,1-1.151.6q-3.585.265-7.641.189-2.377-.038-3.387-.085a11.337,11.337,0,0,1-1.5-.142,2.206,2.206,0,0,1-1.113-.585,2.562,2.562,0,0,1-.528-1.037,3.523,3.523,0,0,1-.141-.585c-.032-.2-.06-.5-.085-.906a38.894,38.894,0,0,1,0-4.867l.113-.925a4.382,4.382,0,0,1,.208-.906,2.069,2.069,0,0,1,.491-.755,2.409,2.409,0,0,1,1.113-.566,19.2,19.2,0,0,1,2.292-.151q1.82-.056,3.953-.056t3.952.066q1.821.067,2.311.142a2.3,2.3,0,0,1,.726.283,1.865,1.865,0,0,1,.557.49,3.425,3.425,0,0,1,.434,1.019,5.72,5.72,0,0,1,.189,1.075q0,.095.057,1C967.752,1364.1,967.759,1364.677,967.759,1365.592Zm-7.6.925q1.49-.754,2.113-1.094l-4.434-2.339v4.66Q958.609,1367.311,960.156,1366.517Z" transform="translate(-951.269 -1359.8)" fill="currentColor"></path>
                                    </svg>
                                    <span class="visually-hidden">Youtube</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>

    </section>

    {{-- Google Map --}}
    <div class="contact__map--area">
        {!! GlobalSiteSettings()->site_google_map !!}
    </div>

    @push('scripts')
        <script>
            function showContactToast(type, message) {
                const config = {
                    success: {
                        bg: '#15803D',
                        title: 'Success',
                        svg: '<path fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M20 6 9 17 4 12"/>'
                    },
                    error: {
                        bg: '#B91C1C',
                        title: 'Error',
                        svg: '<circle cx="12" cy="12" r="10" stroke="#fff" fill="none" stroke-width="2.5"/><line x1="12" y1="8" x2="12" y2="13" stroke="#fff" stroke-width="2.5"/><circle cx="12" cy="16.5" r="1" fill="#fff"/>'
                    },
                };

                const cfg = config[type];
                if (!cfg) return;

                const $toast = $('#contact__toast');
                $toast.css('background', cfg.bg);
                $('#contact__toast--title').text(cfg.title);
                $('#contact__toast--message').text(message);
                $('#contact__toast--svg').html(cfg.svg);

                $toast.css('display', 'flex').hide().fadeIn(300); // ← এইটা fix

                setTimeout(function() {
                    $toast.fadeOut(400);
                }, 3000);
            }

            // Form Submit
            $('.contact__form--inner').on('submit', function(e) {
                e.preventDefault();

                const $form = $(this);
                const $btn = $form.find('.contact__form--btn');
                const orig = $btn.html();

                $btn.prop('disabled', true).html('<span>Sending...</span>');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(res) {
                        showContactToast('success', res.message);
                        $form[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON?.errors ?? {};
                            const first = Object.values(errors)[0]?.[0] ?? 'Validation failed.';
                            showContactToast('error', first);
                        } else {
                            showContactToast('error', xhr.responseJSON?.message ?? 'Something went wrong!');
                        }
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(orig);
                    }
                });
            });
        </script>
    @endpush

@endsection
