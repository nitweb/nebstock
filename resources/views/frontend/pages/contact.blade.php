@extends('frontend.dashboard')
@section('frontend_title', 'Contact')
@section('frontend_contents')

    {{-- Breadcrumb Section --}}
    <section class="breadcrumb border-bottom p-0 d-block section-bg position-relative z-index-1">
        <div class="breadcrumb-two">
            <img src="{{ asset('frontend/assets/images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">
            <div class="container container-two">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="breadcrumb-two-content text-center">

                            <ul class="breadcrumb-list flx-align gap-2 mb-2 justify-content-center">
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <a href="{{ route('index') }}" class="breadcrumb-list__link text-body hover-text-main">Home</a>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__icon font-10"><i class="fas fa-chevron-right"></i></span>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__text">Contact</span>
                                </li>
                            </ul>
                            <h3 class="breadcrumb-two-content__title mb-0 text-capitalize">Contact Us</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="contact padding-t-120 padding-b-60 section-bg position-relative z-index-1 overflow-hidden">
        <img src="{{ asset('frontend/assets/images/gradients/banner-two-gradient.png') }}" alt="" class="bg--gradient">
        <img src="{{ asset('frontend/assets/images/shapes/pattern-five.png') }}" class="position-absolute end-0 top-0 z-index--1" alt="">
        <div class="container container-two">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="contact-info">
                        <h3 class="contact-info__title">Get in touch with us today</h3>
                        <p class="contact-info__desc">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatum rem facere labore cupiditate sint? Animi quis illo suscipit autem cum.</p>

                        {{-- Info Cards --}}
                        <div class="contact-info__cards mt-32 d-flex flex-column gap-3">

                            <div class="contact-info__card d-flex align-items-start gap-3 p-3 border rounded-3">
                                <span class="contact-info__card-icon flx-center flex-shrink-0 rounded-circle bg-main-50" style="width:48px;height:48px;">
                                    <i class="fas fa-envelope text-main"></i>
                                </span>
                                <div>
                                    <span class="contact-info__text text-capitalize d-block mb-1 font-14 text-body">Email Address</span>
                                    <a href="mailto:{{ GlobalSiteSettings()->site_email }}" class="contact-info__link d-block font-18 fw-500 text-heading hover-text-main">{{ GlobalSiteSettings()->site_email }}</a>
                                    @if (GlobalSiteSettings()->site_email_alt)
                                        <a href="mailto:{{ GlobalSiteSettings()->site_email_alt }}" class="contact-info__link d-block font-16 fw-400 text-body hover-text-main">{{ GlobalSiteSettings()->site_email_alt }}</a>
                                    @endif
                                </div>
                            </div>

                            <div class="contact-info__card d-flex align-items-start gap-3 p-3 border rounded-3">
                                <span class="contact-info__card-icon flx-center flex-shrink-0 rounded-circle bg-main-50" style="width:48px;height:48px;">
                                    <i class="fas fa-phone-alt text-main"></i>
                                </span>
                                <div>
                                    <span class="contact-info__text text-capitalize d-block mb-1 font-14 text-body">Phone Number</span>
                                    <a href="tel:{{ GlobalSiteSettings()->site_phone }}" class="contact-info__link d-block font-18 fw-500 text-heading hover-text-main">{{ GlobalSiteSettings()->site_phone }}</a>
                                    @if (GlobalSiteSettings()->site_phone_alt)
                                        <a href="tel:{{ GlobalSiteSettings()->site_phone_alt }}" class="contact-info__link d-block font-16 fw-400 text-body hover-text-main">{{ GlobalSiteSettings()->site_phone_alt }}</a>
                                    @endif
                                </div>
                            </div>

                            <div class="contact-info__card d-flex align-items-start gap-3 p-3 border rounded-3">
                                <span class="contact-info__card-icon flx-center flex-shrink-0 rounded-circle bg-main-50" style="width:48px;height:48px;">
                                    <i class="fas fa-map-marker-alt text-main"></i>
                                </span>
                                <div>
                                    <span class="contact-info__text text-capitalize d-block mb-1 font-14 text-body">Office Location</span>
                                    <span class="contact-info__link d-block font-18 fw-500 text-heading">{{ GlobalSiteSettings()->site_address }}</span>
                                </div>
                            </div>

                        </div>

                        <div class="mt-32">
                            <ul class="social-icon-list">
                                <li class="social-icon-list__item">
                                    <a href="https://www.facebook.com/" class="social-icon-list__link text-heading flx-center"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.twitter.com/" class="social-icon-list__link text-heading flx-center"> <i class="fab fa-twitter"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.linkedin.com/" class="social-icon-list__link text-heading flx-center"> <i class="fab fa-linkedin-in"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.pinterest.com/" class="social-icon-list__link text-heading flx-center"> <i class="fab fa-pinterest-p"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.pinterest.com/" class="social-icon-list__link text-heading flx-center"> <i class="fab fa-youtube"></i></a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-7 ps-lg-5">
                    <div class="card common-card p-sm-4">
                        <div class="card-body">

                            <form action="{{ route('contact.submit') }}" method="POST" autocomplete="off">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-6 col-xs-6">
                                        <label for="name" class="form-label mb-2 font-18 font-heading fw-600">Full Name</label>
                                        <input type="text" class="common-input common-input--grayBg border" name="contact_form_name" id="name" value="{{ old('contact_form_name') }}" placeholder="Your name here" required>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <label for="email" class="form-label mb-2 font-18 font-heading fw-600">Your Mail</label>
                                        <input type="email" class="common-input common-input--grayBg border" name="contact_form_email" id="email" value="{{ old('contact_form_email') }}" placeholder="Your email here" required>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <label for="phone" class="form-label mb-2 font-18 font-heading fw-600">Phone</label>
                                        <input type="text" class="common-input common-input--grayBg border" name="contact_form_phone" id="phone" value="{{ old('contact_form_phone') }}" placeholder="Your phone number">
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <label for="subject" class="form-label mb-2 font-18 font-heading fw-600">Subject</label>
                                        <input type="text" class="common-input common-input--grayBg border" name="contact_form_subject" id="subject" value="{{ old('contact_form_subject') }}" placeholder="Enter subject" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="message" class="form-label mb-2 font-18 font-heading fw-600">Your Message</label>
                                        <textarea class="common-input common-input--grayBg border" name="contact_form_message" id="message" placeholder="Write Your Message Here" required>{{ old('contact_form_message') }}</textarea>
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-main btn-lg pill w-100" type="submit"> Submit Now </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Newsletter Section --}}
    <section class="newsletter-two padding-t-60 padding-b-120 section-bg position-relative z-index-1 overflow-hidden">
        <img src="{{ asset('frontend/assets/images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">
        <img src="{{ asset('frontend/assets/images/shapes/element-moon3.png') }}" alt="" class="element one">
        <img src="{{ asset('frontend/assets/images/shapes/element-moon1.png') }}" alt="" class="element three">
        <div class="container container-two">
            <div class="flx-between gap-3">
                <div class="newsletter-two-content">
                    <h3 class="newsletter-two-content__title mb-3">Get all items for just $59!</h3>
                    <p class="newsletter-two-content__desc text-heading font-18">With our broad assortment of components, making and tweaking designs becomes natural. Disregard coding and partake in our topics.</p>
                </div>
                <a href="javascript:void(0)" class="btn btn-main btn-lg pill">Grabe All Product</a>
            </div>
        </div>
    </section>

    {{-- Google Map Section --}}
    <section class="contact-map position-relative z-index-1">
        <div class="contact-map__wrapper" style="position: relative; overflow: hidden; padding-top: 40%;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.401711413199!2d90.36740127533763!3d23.804310278633675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c0d6aaa2cb19%3A0xb24da85cafcddc26!2sNebula%20IT!5e0!3m2!1sen!2sbd!4v1785392011722!5m2!1sen!2sbd" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin">
            </iframe>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: @json(session('success')),
                    confirmButtonColor: '#0d6efd',
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: @json(session('error')),
                    confirmButtonColor: '#dc3545',
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: @json($errors->first()),
                    confirmButtonColor: '#dc3545',
                });
            @endif
        </script>
    @endpush

@endsection
