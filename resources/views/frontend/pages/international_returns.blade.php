@extends('frontend.dashboard')
@section('frontend_title', 'International Returns')
@section('frontend_contents')

    @include('frontend.partials.page_breadcrumb', ['pageTitle' => 'International Returns'])

    <section class="static-page padding-y-120">
        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <p class="text-body font-14 mb-4">Last updated: {{ now()->format('d M, Y') }}</p>

                    <p class="mb-4">{{ config('app.name') }} serves customers worldwide. Since all products are digital and delivered by direct download, there are no customs, shipping borders, or international carrier delays to worry about — the same policy applies no matter where you are located.</p>

                    <h5 class="mb-3">1. Same Policy Everywhere</h5>
                    <p class="mb-4">Whether you are downloading from inside the country or from abroad, the same account, download, and refund rules apply equally. There is no separate "international" process.</p>

                    <h5 class="mb-3">2. Currency & Pricing</h5>
                    <p class="mb-4">Prices displayed on the site are shown in the platform's default currency. Any currency conversion during payment (if applicable) is handled by your payment provider or bank.</p>

                    <h5 class="mb-3">3. Refunds for International Customers</h5>
                    <p class="mb-4">International customers are eligible for the same refund conditions as local customers — please review our <a href="{{ route('refund.conditions') }}">Refund Conditions</a> page for details.</p>

                    <h5 class="mb-3">4. Contact Us</h5>
                    <p class="mb-0">For any questions regardless of your location, contact us at
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
