@extends('frontend.dashboard')
@section('frontend_title', 'Terms & Conditions')
@section('frontend_contents')

    @include('frontend.partials.page_breadcrumb', ['pageTitle' => 'Terms & Conditions'])

    <section class="static-page padding-y-120">
        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <p class="text-body font-14 mb-4">Last updated: {{ now()->format('d M, Y') }}</p>

                    <p class="mb-4">Welcome to {{ config('app.name') }}. These Terms & Conditions govern your use of our website and the digital products available for download. By accessing or using our site, you agree to be bound by these terms.</p>

                    <h5 class="mb-3">1. Use of Our Service</h5>
                    <p class="mb-4">You must register an account to download any digital product from {{ config('app.name') }}. You agree to provide accurate information during registration and to keep your account credentials secure. You are responsible for all activity that occurs under your account.</p>

                    <h5 class="mb-3">2. Digital Products & Licensing</h5>
                    <p class="mb-4">All products offered on this platform are digital and delivered via direct download after successful account verification. Unless otherwise stated on the product page, purchased or downloaded items are licensed for personal or as-described use only and may not be resold, redistributed, or shared without prior written permission.</p>

                    <h5 class="mb-3">3. Account Responsibilities</h5>
                    <p class="mb-4">You agree not to misuse the platform, attempt unauthorized access to other accounts, or use automated tools to scrape or download content in bulk. We reserve the right to suspend or terminate accounts that violate these terms.</p>

                    <h5 class="mb-3">4. Intellectual Property</h5>
                    <p class="mb-4">All content on {{ config('app.name') }}, including logos, design, and site text, is the property of {{ config('app.name') }} or its licensors and is protected by applicable intellectual property laws.</p>

                    <h5 class="mb-3">5. Changes to These Terms</h5>
                    <p class="mb-4">We may update these Terms & Conditions from time to time. Continued use of the site after changes are posted constitutes acceptance of the revised terms.</p>

                    <h5 class="mb-3">6. Contact Us</h5>
                    <p class="mb-0">If you have any questions about these Terms & Conditions, please contact us at
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
