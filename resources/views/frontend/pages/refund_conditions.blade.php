@extends('frontend.dashboard')
@section('frontend_title', 'Refund Conditions')
@section('frontend_contents')

    @include('frontend.partials.page_breadcrumb', ['pageTitle' => 'Refund Conditions'])

    <section class="static-page padding-y-120">
        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <p class="text-body font-14 mb-4">Last updated: {{ now()->format('d M, Y') }}</p>

                    <p class="mb-4">Because {{ config('app.name') }} provides digital products delivered instantly via direct download, our refund policy differs from that of physical goods. Please read the conditions below carefully before requesting a download.</p>

                    <h5 class="mb-3">1. Digital Product Nature</h5>
                    <p class="mb-4">All items on this platform are digital files. Once a product has been downloaded, it cannot be "returned" in the traditional sense, and access to the file itself cannot be revoked.</p>

                    <h5 class="mb-3">2. Eligible Refund Cases</h5>
                    <p class="mb-4">A refund may be considered only in the following situations: the downloaded file is corrupted or fails to open, the file delivered does not match the product description, or a duplicate charge was made in error.</p>

                    <h5 class="mb-3">3. Non-Refundable Cases</h5>
                    <p class="mb-4">Refunds will not be issued for change of mind after a successful download, incompatibility with your personal software/hardware that was disclosed on the product page, or requests made after the refund window has closed.</p>

                    <h5 class="mb-3">4. How to Request a Refund</h5>
                    <p class="mb-4">To request a refund, please contact us within 7 days of your download through our <a href="{{ route('contact') }}">Contact page</a>, including your account email and the product name. Our team will review your request and respond within 2–3 business days.</p>

                    <h5 class="mb-3">5. Contact Us</h5>
                    <p class="mb-0">Questions about a refund? Email us at
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
