@extends('frontend.dashboard')
@section('frontend_title', 'Privacy Policy')
@section('frontend_contents')

    @include('frontend.partials.page_breadcrumb', ['pageTitle' => 'Privacy Policy'])

    <section class="static-page padding-y-120">
        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <p class="text-body font-14 mb-4">Last updated: {{ now()->format('d M, Y') }}</p>

                    <p class="mb-4">At {{ config('app.name') }}, we respect your privacy and are committed to protecting the personal information you share with us. This policy explains what data we collect, how we use it, and your rights regarding that data.</p>

                    <h5 class="mb-3">1. Information We Collect</h5>
                    <p class="mb-4">When you register, subscribe to our newsletter, or contact us, we may collect your name, email address, phone number, and any other details you voluntarily provide through our forms.</p>

                    <h5 class="mb-3">2. How We Use Your Information</h5>
                    <p class="mb-4">We use the information we collect to create and manage your account, deliver the products you download, send newsletters and updates (only if you subscribe), respond to your inquiries, and improve our platform.</p>

                    <h5 class="mb-3">3. Cookies</h5>
                    <p class="mb-4">Our website may use cookies to remember your preferences and improve your browsing experience. You can disable cookies through your browser settings, though some features of the site may not function properly.</p>

                    <h5 class="mb-3">4. Data Sharing</h5>
                    <p class="mb-4">We do not sell or rent your personal information to third parties. Your data may only be shared with trusted service providers who help us operate the platform (e.g. email delivery), and only to the extent necessary.</p>

                    <h5 class="mb-3">5. Data Security</h5>
                    <p class="mb-4">We take reasonable technical and organizational measures to protect your personal data from unauthorized access, alteration, or disclosure.</p>

                    <h5 class="mb-3">6. Your Rights</h5>
                    <p class="mb-4">You may request to access, update, or delete your personal data at any time, and you can unsubscribe from our newsletter using the link included in any email we send.</p>

                    <h5 class="mb-3">7. Contact Us</h5>
                    <p class="mb-0">For any privacy-related questions, reach out to us at
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
