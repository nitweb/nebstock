@extends('frontend.dashboard')
@section('frontend_title', 'Shipping Policies')
@section('frontend_contents')

    @include('frontend.partials.page_breadcrumb', ['pageTitle' => 'Shipping Policies'])

    <section class="static-page padding-y-120">
        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <p class="text-body font-14 mb-4">Last updated: {{ now()->format('d M, Y') }}</p>

                    <p class="mb-4">{{ config('app.name') }} sells digital products only — nothing is shipped physically. This page explains how delivery works instead of a traditional shipping process.</p>

                    <h5 class="mb-3">1. Instant Digital Delivery</h5>
                    <p class="mb-4">There are no shipping fees, carriers, or delivery times to wait for. Once your account is registered and verified, eligible products can be downloaded directly from the product or shop page.</p>

                    <h5 class="mb-3">2. Account Requirement</h5>
                    <p class="mb-4">To keep downloads secure and traceable, you must be logged in with a registered customer account before the download option becomes available. Guests will be redirected to the login/registration page.</p>

                    <h5 class="mb-3">3. Download Access</h5>
                    <p class="mb-4">Once downloaded, files are yours to keep on your device. We recommend saving a backup copy, as re-download availability may vary depending on the product.</p>

                    <h5 class="mb-3">4. Technical Issues</h5>
                    <p class="mb-4">If a download fails to start, times out, or the file appears corrupted, please contact our support team right away so we can help resolve the issue.</p>

                    <h5 class="mb-3">5. Contact Us</h5>
                    <p class="mb-0">Need help with a download? Contact us at
                        @if(GlobalSiteSettings()->site_email)
                            <a href="mailto:{{ GlobalSiteSettings()->site_email }}">{{ GlobalSiteSettings()->site_email }}</a>.
                        @else
                            our support team via the <a href="{{ route('contact') }}">Contact page</a>.
                        @endif
                    </p>

                </div>
            </div>
        </div>
    </section>

@endsection
