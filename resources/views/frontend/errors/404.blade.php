@extends('frontend.dashboard')
@section('frontend_title', 'Error 404')
@section('frontend_content')

    <!-- Start breadcrumb section -->
    <div class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a href="index.html">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span>Error 404</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End breadcrumb section -->

    <!-- Start error section -->
    <section class="error__section section--padding">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="error__content text-center">
                        <img class="error__content--img display-block mb-50" src="{{ asset('frontend/assets/img/other/404-thumb.webp') }}" alt="error-img">
                        <h2 class="error__content--title">Opps ! We,ar Not Found This Page </h2>
                        <a class="error__content--btn primary__btn" href="{{ route('index') }}">Back To Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End error section -->

@endsection
