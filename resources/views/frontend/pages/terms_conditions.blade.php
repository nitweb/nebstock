@extends('frontend.dashboard')
@section('frontend_title', 'Terms & Conditions')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Terms & Conditions</h1>
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
                        <h2 class="privacy__policy--content__title">Terms & Conditions</h2>
                        <p class="privacy__policy--content__desc">
                            Last updated: {{ date('F d, Y') }}<br>
                            Please read these Terms & Conditions carefully before using the Nicole Murray
                            website or placing any order. By accessing our website or making a purchase,
                            you agree to be bound by these terms. If you do not agree with any part of
                            these terms, please do not use our website.
                        </p>
                    </div>

                    {{-- About Us --}}
                    <div class="privacy__policy--content section_2">
                        <h2 class="privacy__policy--content__title">1. About Us</h2>
                        <p class="privacy__policy--content__desc">
                            Nicole Murray is an online bookstore dedicated to providing quality books
                            and reading materials. References to "we", "us", or "our" throughout these
                            terms refer to Nicole Murray. References to "you" or "your" refer to the
                            customer or visitor using our website.
                        </p>
                    </div>

                    {{-- Use of Website --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">2. Use of Our Website</h2>

                        <h3 class="privacy__policy--content__subtitle">Eligibility</h3>
                        <p class="privacy__policy--content__desc">
                            You must be at least 18 years of age to place an order on our website.
                            If you are under 18, you may only make a purchase with the involvement
                            and consent of a parent or legal guardian.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Account Responsibility</h3>
                        <p class="privacy__policy--content__desc">
                            If you create an account with us, you are responsible for maintaining the
                            confidentiality of your login credentials and for all activity that occurs
                            under your account. Please notify us immediately if you suspect any
                            unauthorised use of your account.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Prohibited Use</h3>
                        <p class="privacy__policy--content__desc">
                            You agree not to use our website for any unlawful purpose, to attempt to
                            gain unauthorised access to any part of our system, to submit false or
                            misleading information, to abuse discount codes or coupon systems, or to
                            engage in any conduct that disrupts or damages the website or other users'
                            experience.
                        </p>
                    </div>

                    {{-- Orders --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">3. Orders & Purchases</h2>

                        <h3 class="privacy__policy--content__subtitle">Placing an Order</h3>
                        <p class="privacy__policy--content__desc">
                            When you place an order through our website, you are making an offer to
                            purchase the selected items. All orders are subject to acceptance and
                            availability. We reserve the right to refuse or cancel any order at our
                            discretion, including in cases of pricing errors, stock unavailability,
                            or suspected fraudulent activity.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Order Confirmation</h3>
                        <p class="privacy__policy--content__desc">
                            Once your order is successfully placed, you will receive a confirmation
                            notification. This confirmation does not guarantee shipment — it simply
                            confirms that we have received your order. In the rare event that an item
                            becomes unavailable after your order is placed, we will contact you promptly.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Pricing</h3>
                        <p class="privacy__policy--content__desc">
                            All prices displayed on our website are in US Dollars (USD) unless otherwise
                            stated. Prices are subject to change without notice. The price charged for
                            your order will be the price displayed at the time of checkout. We are not
                            obligated to honour pricing errors and reserve the right to cancel orders
                            placed at an incorrect price.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Discount Codes & Coupons</h3>
                        <p class="privacy__policy--content__desc">
                            Discount codes and coupons are subject to their individual terms, including
                            expiry dates, minimum order values, and usage limits. Only one discount code
                            may be applied per order unless otherwise stated. Codes have no cash value
                            and cannot be combined with other promotions unless explicitly advertised.
                        </p>
                    </div>

                    {{-- Payment --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">4. Payment</h2>
                        <p class="privacy__policy--content__desc">
                            We accept payment via PayPal, Cash on Delivery (where available), and Bank
                            Transfer. By providing payment details, you confirm that you are authorised
                            to use the selected payment method. All transactions are processed securely.
                            We do not store your full card or banking details on our servers.
                        </p>
                        <p class="privacy__policy--content__desc">
                            For Bank Transfer orders, payment must be completed within 3 business days
                            of placing your order. Orders awaiting bank transfer payment will be held
                            for this period and cancelled if payment is not received.
                        </p>
                    </div>

                    {{-- Shipping --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">5. Shipping & Delivery</h2>

                        <h3 class="privacy__policy--content__subtitle">Shipping Methods & Costs</h3>
                        <p class="privacy__policy--content__desc">
                            Available shipping methods and their costs are displayed at checkout based
                            on your delivery country. Shipping rates are calculated at the time of order
                            and are non-refundable unless the return is due to our error.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Delivery Timeframes</h3>
                        <p class="privacy__policy--content__desc">
                            Estimated delivery timeframes are provided as a guide only and are not
                            guaranteed. We are not liable for delays caused by courier services,
                            customs processing, public holidays, or circumstances beyond our control.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">PO Box Deliveries</h3>
                        <p class="privacy__policy--content__desc">
                            Certain shipping methods (such as Economy USPS) are available exclusively
                            for PO Box addresses within the United States. It is your responsibility
                            to ensure your address is correct and compatible with the chosen shipping
                            method at the time of checkout.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">International Orders</h3>
                        <p class="privacy__policy--content__desc">
                            For international deliveries, you may be subject to import duties, customs
                            taxes, or local fees upon arrival of your package. These charges are the
                            sole responsibility of the customer and are not included in our pricing
                            or shipping costs.
                        </p>
                    </div>

                    {{-- Returns --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">6. Returns & Refunds</h2>

                        <h3 class="privacy__policy--content__subtitle">All Sales Are Final</h3>
                        <p class="privacy__policy--content__desc">
                            Due to the nature of our products, all sales are considered final once an
                            order has been dispatched. We do not accept returns or exchanges for change
                            of mind purchases.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Damaged or Incorrect Items</h3>
                        <p class="privacy__policy--content__desc">
                            If your order arrives damaged, defective, or incorrect, please contact us
                            within 7 days of receiving your package at
                            <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a> with your
                            order number and photographic evidence. We will assess each case individually
                            and offer a replacement or refund where appropriate.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Lost Orders</h3>
                        <p class="privacy__policy--content__desc">
                            If your order has not arrived within the estimated delivery window, please
                            contact us so we can investigate with the courier. We are not responsible
                            for packages lost due to an incorrect address provided by the customer.
                        </p>
                    </div>

                    {{-- Intellectual Property --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">7. Intellectual Property</h2>
                        <p class="privacy__policy--content__desc">
                            All content on this website — including text, images, logos, product
                            descriptions, and design elements — is the property of Nicole Murray or
                            its respective rights holders and is protected by applicable copyright
                            and intellectual property laws. You may not reproduce, distribute, or
                            use any content from this website without our prior written permission.
                        </p>
                    </div>

                    {{-- Limitation of Liability --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">8. Limitation of Liability</h2>
                        <p class="privacy__policy--content__desc">
                            To the fullest extent permitted by law, Nicole Murray shall not be liable
                            for any indirect, incidental, special, or consequential damages arising
                            from your use of our website or products. Our total liability to you for
                            any claim arising from a purchase shall not exceed the amount you paid for
                            the order in question.
                        </p>
                    </div>

                    {{-- Third Party Links --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">9. Third-Party Links</h2>
                        <p class="privacy__policy--content__desc">
                            Our website may contain links to third-party websites for your convenience.
                            We have no control over the content or privacy practices of those websites
                            and accept no responsibility for them. Accessing third-party links is done
                            entirely at your own risk.
                        </p>
                    </div>

                    {{-- Changes to Terms --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">10. Changes to These Terms</h2>
                        <p class="privacy__policy--content__desc">
                            We reserve the right to update or modify these Terms & Conditions at any
                            time without prior notice. Any changes will be effective immediately upon
                            posting to this page with a revised "Last updated" date. Your continued
                            use of our website following any changes constitutes your acceptance of
                            the updated terms.
                        </p>
                    </div>

                    {{-- Governing Law --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">11. Governing Law</h2>
                        <p class="privacy__policy--content__desc">
                            These Terms & Conditions are governed by and construed in accordance with
                            applicable law. Any disputes arising from your use of this website or your
                            purchases shall be subject to the exclusive jurisdiction of the relevant
                            courts, and you agree to submit to such jurisdiction.
                        </p>
                    </div>

                    {{-- Contact --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">12. Contact Us</h2>
                        <p class="privacy__policy--content__desc">
                            If you have any questions about these Terms & Conditions, please contact us:
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
