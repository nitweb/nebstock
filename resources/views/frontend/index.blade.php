@extends('frontend.dashboard')
@section('frontend_title', 'Home')
@section('frontend_content')

    @include('frontend.home.01_slider')

    @include('frontend.home.02_category_banner')

    @include('frontend.home.03_featured_product')

    {{-- ── Dynamic Category Product Sections ─────────────────────────────── --}}
    @foreach ($categories as $cat)
        @include('frontend.home.category_collection', ['cat' => $cat])
    @endforeach

    {{-- @include('frontend.home.05_feature') --}}

    {{-- @include('frontend.home.06_blog') --}}

@endsection
