@extends('frontend.dashboard')
@section('frontend_title', 'Home')
@section('frontend_contents')

    {{-- Banner Section --}}
    @include('frontend.home.01_banner')

    {{-- popular Section --}}
    @include('frontend.home.02_popular')

    {{-- Arrival Product Section --}}
    @include('frontend.home.03_arrival_product')

    {{-- Featured Products --}}
    {{-- @include('frontend.home.04_featured_products') --}}

    {{-- Selling Products --}}
    {{-- @include('frontend.home.05_selling_products') --}}

    {{-- To Featured Author --}}
    {{-- @include('frontend.home.06_top_featured_author') --}}

    {{-- Top performance Author --}}
    {{-- @include('frontend.home.07_top_performance') --}}

    {{-- Become seller section --}}
    @include('frontend.home.08_become_seller')

@endsection
