@extends('frontend.dashboard')
@section('frontend_title', 'Privacy Policy')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Privacy Policy</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Policies</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Polices --}}
    <div class="privacy__policy--section section--padding">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    {{-- Intro --}}
                    <div class="privacy__policy--content">
                        <h2 class="privacy__policy--content__title">Privacy Policy</h2>
                        <p class="privacy__policy--content__desc">
                            Last updated: {{ date('F d, Y') }}<br>
                            Welcome to <strong>Nicole Murray</strong> ("we", "our", or "us"). We are committed to protecting
                            your personal information and your right to privacy. This Privacy Policy explains how we collect,
                            use, and safeguard your information when you visit our website and make purchases from our
                            online bookstore.
                        </p>
                    </div>

                    {{-- Information We Collect --}}
                    <div class="privacy__policy--content section_2">
                        <h2 class="privacy__policy--content__title">Information We Collect</h2>

                        <h3 class="privacy__policy--content__subtitle">Personal Information</h3>
                        <p class="privacy__policy--content__desc">
                            When you place an order, create an account, or contact us, we may collect the following
                            information: your full name, email address, phone number, billing and shipping address,
                            and payment details (processed securely — we do not store card numbers).
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Order & Purchase Information</h3>
                        <p class="privacy__policy--content__desc">
                            We collect details about the books and products you purchase, your order history,
                            and any preferences or notes you provide during checkout. This helps us process
                            and deliver your orders accurately.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Automatically Collected Information</h3>
                        <p class="privacy__policy--content__desc">
                            When you browse our website, we may automatically collect certain technical information
                            such as your IP address, browser type, device information, referring URLs, and pages
                            visited. This data is used solely for analytics and improving website performance.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Cookies</h3>
                        <p class="privacy__policy--content__desc">
                            We use cookies to maintain your shopping cart session, remember your login preferences,
                            and understand how visitors interact with our site. You may disable cookies in your
                            browser settings, though this may affect certain features such as the cart and checkout.
                        </p>
                    </div>

                    {{-- How We Use Your Information --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">How We Use Your Information</h2>
                        <p class="privacy__policy--content__desc">We use the information we collect to:</p>
                        <p class="privacy__policy--content__desc">
                            Process and fulfill your book orders and send you order confirmations and shipping updates.
                            Manage your account and provide customer support. Send you newsletters, promotions, or
                            updates about new releases — only if you have opted in. Improve our website, product
                            listings, and overall shopping experience. Comply with legal obligations and prevent
                            fraudulent transactions.
                        </p>
                    </div>

                    {{-- Sharing Your Information --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">Sharing Your Information</h2>
                        <p class="privacy__policy--content__desc">
                            We do not sell, trade, or rent your personal information to third parties.
                            We may share your data only in the following limited circumstances:
                        </p>
                        <p class="privacy__policy--content__desc">
                            <strong>Shipping partners:</strong> Your name and delivery address are shared with
                            our courier or postal service solely for the purpose of delivering your order.
                            <br><br>
                            <strong>Payment processors:</strong> Payment information is handled by trusted
                            third-party payment gateways (such as PayPal) under their own privacy and
                            security policies. We do not have access to your full card details.
                            <br><br>
                            <strong>Legal requirements:</strong> We may disclose your information if required
                            by law or to protect the rights, property, or safety of our business or customers.
                        </p>
                    </div>

                    {{-- Data Retention --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">How Long We Retain Your Data</h2>
                        <p class="privacy__policy--content__desc">
                            We retain your personal information for as long as your account is active or as
                            needed to fulfill your orders and comply with our legal obligations. If you wish
                            to delete your account or request removal of your data, please contact us and we
                            will process your request within a reasonable timeframe, except where retention
                            is required by law.
                        </p>
                    </div>

                    {{-- Your Rights --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">Your Rights</h2>
                        <p class="privacy__policy--content__desc">
                            You have the right to access, correct, or delete the personal information we
                            hold about you. You may also withdraw consent for marketing communications at
                            any time by clicking "Unsubscribe" in any email we send, or by contacting us
                            directly. To exercise any of these rights, please reach out to us at the
                            contact details below.
                        </p>
                    </div>

                    {{-- Data Security --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">Data Security</h2>
                        <p class="privacy__policy--content__desc">
                            We take the security of your personal information seriously. Our website uses
                            SSL encryption to protect data transmitted between your browser and our servers.
                            Access to your personal information is restricted to authorised personnel only.
                            However, no method of transmission over the internet is 100% secure, and we
                            cannot guarantee absolute security.
                        </p>
                    </div>

                    {{-- Children's Privacy --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">Children's Privacy</h2>
                        <p class="privacy__policy--content__desc">
                            Our website is not directed at children under the age of 13. We do not knowingly
                            collect personal information from children. If you believe a child has provided
                            us with personal information, please contact us immediately and we will take
                            steps to remove that information.
                        </p>
                    </div>

                    {{-- Changes to Policy --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">Changes to This Privacy Policy</h2>
                        <p class="privacy__policy--content__desc">
                            We may update this Privacy Policy from time to time to reflect changes in our
                            practices or for legal reasons. When we do, we will revise the "Last updated"
                            date at the top of this page. We encourage you to review this policy periodically
                            to stay informed about how we are protecting your information.
                        </p>
                    </div>

                    {{-- Contact --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">Contact Us</h2>
                        <p class="privacy__policy--content__desc">
                            If you have any questions, concerns, or requests regarding this Privacy Policy
                            or the way we handle your personal data, please do not hesitate to contact us:
                            <br><br>
                            <strong>Nicole Murray</strong><br>
                            Email: <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a><br>
                            Website: <a href="{{ url('/') }}">{{ url('/') }}</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
