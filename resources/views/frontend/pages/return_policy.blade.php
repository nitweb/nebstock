@extends('frontend.dashboard')
@section('frontend_title', 'Return Policy')
@section('frontend_contents')

    @include('frontend.partials.page_breadcrumb', ['pageTitle' => 'Return Policy'])

    <section class="static-page padding-y-120">
        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <p class="text-body font-14 mb-4">Last updated: {{ now()->format('d M, Y') }}</p>

                    <p class="mb-4">{{ config('app.name') }} deals exclusively in digital products delivered by direct download. As such, our return policy is designed around the nature of digital goods rather than physical merchandise.</p>

                    <h5 class="mb-3">1. No Physical Returns</h5>
                    <p class="mb-4">Since no physical item is shipped to you, there is nothing to physically return. Any concerns about a downloaded product should instead be raised as a support or refund request.</p>

                    <h5 class="mb-3">2. Faulty or Incorrect Files</h5>
                    <p class="mb-4">If a downloaded file is damaged, incomplete, or does not match what was described on the product page, please contact our support team so we can resend the correct file or process a resolution.</p>

                    <h5 class="mb-3">3. Account-Based Access</h5>
                    <p class="mb-4">Downloads are tied to your registered account. If you believe a download was made in error or without your authorization, contact us immediately so we can investigate.</p>

                    <h5 class="mb-3">4. Related Policies</h5>
                    <p class="mb-4">For information about eligibility for a monetary refund, please see our <a href="{{ route('refund.conditions') }}">Refund Conditions</a> page.</p>

                    <h5 class="mb-3">5. Contact Us</h5>
                    <p class="mb-0">Reach out to us anytime at
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
