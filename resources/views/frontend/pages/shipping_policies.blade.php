@extends('frontend.dashboard')
@section('frontend_title', 'Shipping Policies')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Shipping Policies</h1>
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
                        <h2 class="privacy__policy--content__title">Shipping Policy</h2>
                        <p class="privacy__policy--content__desc">
                            Last updated: {{ date('F d, Y') }}<br>
                            At <strong>Nicole Murray</strong>, we are committed to getting your books
                            to you as safely and efficiently as possible. This Shipping Policy outlines
                            everything you need to know about how we process, dispatch, and deliver
                            your orders — whether you are shopping locally or from the other side
                            of the world.
                        </p>
                    </div>

                    {{-- Order Processing --}}
                    <div class="privacy__policy--content section_2">
                        <h2 class="privacy__policy--content__title">1. Order Processing Time</h2>
                        <p class="privacy__policy--content__desc">
                            All orders are processed within <strong>1 to 3 business days</strong>
                            of payment confirmation. Orders placed on weekends or public holidays
                            will begin processing on the next available business day. During peak
                            periods — such as new book launches, promotional sales, or holiday
                            seasons — processing times may extend slightly. We will always
                            communicate any significant delays to you via email.
                        </p>
                        <p class="privacy__policy--content__desc">
                            Once your order has been dispatched, you will receive a confirmation
                            notification containing your tracking number (where applicable) and
                            estimated delivery timeframe.
                        </p>
                    </div>

                    {{-- Shipping Methods --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">2. Available Shipping Methods</h2>
                        <p class="privacy__policy--content__desc">
                            The shipping methods available to you will depend on your delivery country
                            and are displayed at checkout. Shipping costs are calculated automatically
                            based on your location and chosen method. Below is a general overview of
                            our shipping options:
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Standard Shipping</h3>
                        <p class="privacy__policy--content__desc">
                            Our most popular option for both domestic and international orders.
                            Standard shipping offers a reliable and cost-effective delivery service
                            with estimated delivery timeframes of <strong>5 to 10 business days</strong>
                            for domestic orders and <strong>10 to 25 business days</strong> for
                            international orders, depending on the destination country.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Express Shipping</h3>
                        <p class="privacy__policy--content__desc">
                            For customers who need their books sooner, express shipping is available
                            for select countries. Estimated delivery is <strong>2 to 5 business days</strong>
                            for domestic orders and <strong>5 to 10 business days</strong> for
                            international orders. Express shipping is offered at an additional cost
                            displayed at checkout.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Economy Shipping (USPS — US PO Box Only)</h3>
                        <p class="privacy__policy--content__desc">
                            Economy shipping via USPS is available exclusively for customers in the
                            United States with a valid PO Box address. Your delivery address must
                            clearly contain "PO Box" or "P.O. Box" to qualify for this method.
                            Estimated delivery is <strong>7 to 14 business days</strong>. This is
                            our most affordable US shipping option.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Local Delivery (where available)</h3>
                        <p class="privacy__policy--content__desc">
                            For customers in select local areas, we may offer a local delivery option
                            at a reduced rate or free of charge. Availability of this method will
                            be indicated at checkout if your address qualifies.
                        </p>
                    </div>

                    {{-- Shipping Costs --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">3. Shipping Costs</h2>
                        <p class="privacy__policy--content__desc">
                            Shipping costs are calculated based on your delivery country and the
                            shipping method selected at checkout. The exact shipping cost will
                            always be displayed clearly before you confirm your order — there
                            are no hidden fees added after checkout.
                        </p>
                        <p class="privacy__policy--content__desc">
                            Shipping costs are non-refundable unless the return is a result of
                            our error, such as a damaged, defective, or incorrect item being sent.
                            Occasionally we may run free shipping promotions — these will be
                            clearly communicated on our website and are subject to their own
                            individual terms.
                        </p>
                    </div>

                    {{-- Delivery Timeframes --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">4. Estimated Delivery Timeframes</h2>
                        <p class="privacy__policy--content__desc">
                            All delivery timeframes are estimates only and begin from the date of
                            dispatch, not the date of order. Actual delivery times may vary depending
                            on your location, local postal service performance, customs processing
                            for international orders, and factors outside our control such as
                            weather events or public holidays.
                        </p>
                        <p class="privacy__policy--content__desc">
                            As a general guide:
                            <br><br>
                            <strong>Domestic Standard:</strong> 5 – 10 business days<br>
                            <strong>Domestic Express:</strong> 2 – 5 business days<br>
                            <strong>US Economy (PO Box):</strong> 7 – 14 business days<br>
                            <strong>International Standard:</strong> 10 – 25 business days<br>
                            <strong>International Express:</strong> 5 – 10 business days<br>
                            <strong>International Economy:</strong> 20 – 45 business days
                        </p>
                        <p class="privacy__policy--content__desc">
                            We are not liable for delays caused by courier services, customs
                            authorities, or any other party beyond our direct control. If your
                            order has not arrived within the maximum estimated timeframe, please
                            contact us and we will investigate on your behalf.
                        </p>
                    </div>

                    {{-- Tracking --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">5. Order Tracking</h2>
                        <p class="privacy__policy--content__desc">
                            Where tracking is available for your chosen shipping method, you will
                            receive a tracking number in your dispatch confirmation email. You can
                            use this number to monitor the progress of your delivery through the
                            relevant courier's website.
                        </p>
                        <p class="privacy__policy--content__desc">
                            Please note that tracking information may take up to <strong>24 to 48 hours</strong>
                            to update after dispatch. Economy and standard international shipments
                            may have limited tracking visibility once the package leaves our dispatch
                            country and enters the destination country's postal network.
                        </p>
                    </div>

                    {{-- International Shipping --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">6. International Shipping</h2>

                        <h3 class="privacy__policy--content__subtitle">Customs & Import Duties</h3>
                        <p class="privacy__policy--content__desc">
                            International orders may be subject to customs inspection and import
                            duties, taxes, or fees levied by your country's government. These
                            charges are entirely outside our control and are the sole responsibility
                            of the customer. We are unable to predict, estimate, or pre-pay these
                            fees on your behalf.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Customs Documentation</h3>
                        <p class="privacy__policy--content__desc">
                            We are legally required to declare the accurate contents and value of
                            every international shipment on customs documentation. We are unable
                            to mark packages as "gifts", under-declare their value, or misrepresent
                            their contents under any circumstances.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Import Restrictions</h3>
                        <p class="privacy__policy--content__desc">
                            It is the customer's responsibility to ensure that the items ordered
                            are legally permitted to be imported into their country. We are not
                            liable for packages seized, delayed, or destroyed by customs authorities
                            due to local import restrictions on books or printed materials.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Country Availability</h3>
                        <p class="privacy__policy--content__desc">
                            We ship to a wide range of countries worldwide. Available shipping
                            destinations are displayed in the country selection at checkout. If
                            your country is not listed, please contact us at
                            <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a>
                            and we will do our best to find a solution for you.
                        </p>
                    </div>

                    {{-- Address Accuracy --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">7. Delivery Address Accuracy</h2>
                        <p class="privacy__policy--content__desc">
                            It is your responsibility to ensure that the delivery address provided
                            at checkout is complete and accurate, including the correct postcode,
                            city, and country. We are not liable for failed deliveries, additional
                            shipping charges, or lost packages resulting from an incorrect or
                            incomplete address being provided.
                        </p>
                        <p class="privacy__policy--content__desc">
                            If you notice an error in your delivery address immediately after placing
                            your order, please contact us as soon as possible at
                            <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a>.
                            We will do our best to update the address before dispatch, but we cannot
                            guarantee changes can be made once an order has been processed.
                        </p>
                    </div>

                    {{-- Failed Delivery --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">8. Failed & Missed Deliveries</h2>
                        <p class="privacy__policy--content__desc">
                            If a delivery attempt is unsuccessful, the courier will typically leave
                            a notification card and either attempt redelivery or hold the package
                            at a local collection point for a set period. It is your responsibility
                            to follow up with the courier using your tracking number to arrange
                            collection or redelivery.
                        </p>
                        <p class="privacy__policy--content__desc">
                            If a package is returned to us due to an unsuccessful delivery, failed
                            collection, or refusal at delivery, we will contact you to arrange
                            reshipment at your cost. If you no longer wish to receive the order,
                            a partial refund of the item value (excluding original and return
                            shipping costs) may be considered at our discretion.
                        </p>
                    </div>

                    {{-- Bulk Orders --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">9. Bulk & Wholesale Orders</h2>
                        <p class="privacy__policy--content__desc">
                            Bulk and wholesale orders may be subject to different shipping rates,
                            methods, and timeframes agreed upon individually at the time of purchase.
                            If you are placing a large order and have specific shipping requirements,
                            please contact us before checkout so we can arrange the most suitable
                            and cost-effective shipping solution for you.
                        </p>
                    </div>

                    {{-- Policy Changes --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">10. Changes to This Policy</h2>
                        <p class="privacy__policy--content__desc">
                            We reserve the right to update or amend this Shipping Policy at any
                            time to reflect changes in our shipping partners, pricing, or processes.
                            Any updates will be published on this page with a revised "Last updated"
                            date. We encourage you to review this policy before placing an order.
                        </p>
                    </div>

                    {{-- Contact --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">11. Contact Us</h2>
                        <p class="privacy__policy--content__desc">
                            If you have any questions about shipping, need help tracking an order,
                            or have a delivery concern, please do not hesitate to get in touch:
                            <br><br>
                            <strong>Nicole Murray</strong><br>
                            Email: <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a><br>
                            Website: <a href="{{ url('/') }}">{{ url('/') }}</a>
                            <br><br>
                            Please include your order number in your message so we can assist
                            you as quickly as possible.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
