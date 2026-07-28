@extends('frontend.dashboard')
@section('frontend_title', 'Data Usage')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Data Usage</h1>
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
                        <h2 class="privacy__policy--content__title">Data Usage Policy</h2>
                        <p class="privacy__policy--content__desc">
                            Last updated: {{ date('F d, Y') }}<br>
                            At <strong>Nicole Murray</strong>, we believe in transparency. This Data Usage Policy
                            explains in plain language exactly what data we collect from you, why we collect it,
                            and how it is used when you browse our bookstore or make a purchase.
                        </p>
                    </div>

                    {{-- What Data We Collect --}}
                    <div class="privacy__policy--content section_2">
                        <h2 class="privacy__policy--content__title">What Data We Collect</h2>

                        <h3 class="privacy__policy--content__subtitle">Account & Registration Data</h3>
                        <p class="privacy__policy--content__desc">
                            When you create an account, we collect your name, email address, and password
                            (stored securely as an encrypted hash). This allows you to log in, track your
                            orders, and manage your preferences over time.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Purchase & Transaction Data</h3>
                        <p class="privacy__policy--content__desc">
                            Every order you place generates a record that includes the items purchased,
                            quantities, prices, applied discounts or coupon codes, shipping method chosen,
                            and payment method used. This data is essential for processing, fulfilling,
                            and providing support for your orders.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Shipping & Address Data</h3>
                        <p class="privacy__policy--content__desc">
                            To deliver your books, we collect your shipping name, street address, city,
                            postal code, and country. If you choose a different billing address, that is
                            stored separately. This data is shared only with the courier service handling
                            your delivery.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Communication Data</h3>
                        <p class="privacy__policy--content__desc">
                            If you contact us via our contact form, submit a bulk order inquiry, or email
                            us directly, we retain your message and contact details so we can respond
                            accurately and follow up when needed.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Browsing & Technical Data</h3>
                        <p class="privacy__policy--content__desc">
                            We automatically collect anonymised technical data such as your browser type,
                            device type, IP address, pages visited, and time spent on the site. This is
                            used purely for diagnosing technical issues and understanding how visitors
                            navigate our store — never for identifying individuals.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Cookie & Session Data</h3>
                        <p class="privacy__policy--content__desc">
                            We use session cookies to keep your shopping cart active while you browse,
                            and persistent cookies to remember your login state if you choose "Save
                            this information for next time." No sensitive personal data is stored
                            inside cookies themselves.
                        </p>
                    </div>

                    {{-- How We Use Your Data --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">How We Use Your Data</h2>

                        <h3 class="privacy__policy--content__subtitle">Order Fulfillment</h3>
                        <p class="privacy__policy--content__desc">
                            Your name, address, and order details are used exclusively to process, pack,
                            and dispatch your book orders. Without this data, we are unable to complete
                            your purchase.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Customer Support</h3>
                        <p class="privacy__policy--content__desc">
                            Order history and contact information allow our team to assist you with
                            returns, missing items, delivery issues, or any other post-purchase queries
                            quickly and accurately.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Marketing & Newsletters</h3>
                        <p class="privacy__policy--content__desc">
                            We will only send you promotional emails, new book announcements, or
                            special offers if you have explicitly opted in. You can unsubscribe at
                            any time using the link in any email we send, and we will remove you
                            from our mailing list promptly.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Website Improvement</h3>
                        <p class="privacy__policy--content__desc">
                            Anonymised browsing data helps us understand which books and categories
                            are most popular, where visitors drop off during checkout, and how we
                            can improve the overall shopping experience on our site.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Fraud Prevention & Security</h3>
                        <p class="privacy__policy--content__desc">
                            We use order and payment data to detect and prevent fraudulent transactions,
                            chargebacks, and abuse of discount codes or coupon systems. This protects
                            both our customers and our business.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Legal Compliance</h3>
                        <p class="privacy__policy--content__desc">
                            Certain data — such as transaction records and invoices — may be retained
                            to comply with applicable tax, accounting, and consumer protection laws,
                            even after an account is closed or deleted.
                        </p>
                    </div>

                    {{-- Data We Do NOT Use --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">What We Do Not Do With Your Data</h2>
                        <p class="privacy__policy--content__desc">
                            We do not sell your personal data to any third party — ever. We do not use
                            your data for automated profiling or decisions that legally affect you. We do
                            not share your information with advertisers. We do not store your full payment
                            card details on our servers — all payment processing is handled by secure,
                            PCI-compliant third-party providers such as PayPal.
                        </p>
                    </div>

                    {{-- Data Sharing --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">Who We Share Your Data With</h2>
                        <p class="privacy__policy--content__desc">
                            Your data is shared only on a strict need-to-know basis with the following
                            trusted service providers:
                            <br><br>
                            <strong>Shipping & courier services</strong> — receive your name and delivery
                            address to fulfil your order.<br><br>
                            <strong>Payment gateways (e.g. PayPal)</strong> — handle transaction processing
                            securely under their own compliance frameworks.<br><br>
                            <strong>Email service providers</strong> — used to send order confirmations and,
                            where opted in, newsletters. They are contractually prohibited from using your
                            data for any other purpose.
                        </p>
                    </div>

                    {{-- Data Retention --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">How Long We Keep Your Data</h2>
                        <p class="privacy__policy--content__desc">
                            Account data is retained for as long as your account remains active. Order and
                            transaction records are kept for a minimum of 5 years in line with standard
                            accounting and tax requirements. Contact form submissions are retained for up
                            to 12 months and then deleted. You may request earlier deletion of any data
                            that is not subject to a legal retention requirement by contacting us directly.
                        </p>
                    </div>

                    {{-- Your Controls --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">Your Data Controls</h2>
                        <p class="privacy__policy--content__desc">
                            You are in control of your data. At any time you may log into your account to
                            view and update your personal information, request a copy of all data we hold
                            about you, ask us to correct inaccurate information, withdraw marketing consent,
                            or request full account deletion. To make any of these requests, contact us at
                            <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a> and we will
                            respond within 7 business days.
                        </p>
                    </div>

                    {{-- Contact --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">Questions About Your Data?</h2>
                        <p class="privacy__policy--content__desc">
                            If you have any questions about how your data is collected or used, please
                            reach out to us — we are happy to help.
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
