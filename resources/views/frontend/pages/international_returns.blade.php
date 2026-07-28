@extends('frontend.dashboard')
@section('frontend_title', 'International Returns')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">International Returns</h1>
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
                        <h2 class="privacy__policy--content__title">International Returns Policy</h2>
                        <p class="privacy__policy--content__desc">
                            Last updated: {{ date('F d, Y') }}<br>
                            At <strong>Nicole Murray</strong>, we ship our books and products to customers
                            around the world. We want every international customer to feel just as supported
                            as our local ones. This International Returns Policy outlines the specific
                            conditions, processes, and limitations that apply to orders shipped outside
                            our primary shipping region. Please read this carefully before making an
                            international purchase.
                        </p>
                    </div>

                    {{-- Scope --}}
                    <div class="privacy__policy--content section_2">
                        <h2 class="privacy__policy--content__title">1. Who This Policy Applies To</h2>
                        <p class="privacy__policy--content__desc">
                            This policy applies to any customer who placed an order that was shipped
                            internationally — meaning the delivery address is in a different country
                            from our dispatch location. If you are unsure whether your order falls
                            under this policy, please contact us at
                            <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a> before
                            proceeding with a return request.
                        </p>
                    </div>

                    {{-- General Position --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">2. Our General Position on International Returns</h2>
                        <p class="privacy__policy--content__desc">
                            Due to the significantly higher cost and complexity of international shipping,
                            we do not accept returns for change of mind on international orders under
                            any circumstances. All international sales are considered final once the
                            order has been dispatched. We strongly encourage international customers
                            to review their orders thoroughly before completing checkout.
                        </p>
                        <p class="privacy__policy--content__desc">
                            However, we remain fully committed to resolving genuine issues such as
                            damaged, defective, or incorrect items regardless of where in the world
                            you are located.
                        </p>
                    </div>

                    {{-- Eligible Claims --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">3. Eligible International Return & Refund Claims</h2>

                        <h3 class="privacy__policy--content__subtitle">Damaged in Transit</h3>
                        <p class="privacy__policy--content__desc">
                            If your order arrives damaged due to mishandling during international
                            shipping, you are eligible to make a claim. You must notify us within
                            <strong>14 days</strong> of the delivery date (we allow additional time
                            for international customers compared to our standard 7-day window).
                            Please provide clear photographs of the outer packaging and the
                            damaged item(s) along with your order number.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Defective Items</h3>
                        <p class="privacy__policy--content__desc">
                            Manufacturing defects such as missing pages, binding faults, or printing
                            errors are covered for international orders. Please contact us within
                            <strong>14 days</strong> of receiving your order with a description and
                            photographs of the defect. We will assess each case and offer a replacement
                            or refund as appropriate.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Incorrect Items Received</h3>
                        <p class="privacy__policy--content__desc">
                            If you received the wrong title, edition, or quantity, we sincerely apologise.
                            Please contact us within <strong>14 days</strong> of delivery with your order
                            number and a photo of what you received. We will arrange to send the correct
                            item at no additional cost, or issue a full refund if the correct item is
                            unavailable.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Lost International Shipments</h3>
                        <p class="privacy__policy--content__desc">
                            International shipments can sometimes experience significant delays due to
                            customs processing, local postal networks, or peak periods. Before raising
                            a lost parcel claim, please allow the following minimum timeframes from
                            your dispatch date:
                            <br><br>
                            <strong>Standard International Shipping:</strong> Up to 30 business days.<br>
                            <strong>Economy International Shipping:</strong> Up to 45 business days.<br>
                            <strong>Express International Shipping:</strong> Up to 15 business days.
                            <br><br>
                            If your order has not arrived after these periods, please contact us and
                            we will open an investigation with the courier. If the shipment is confirmed
                            as lost, we will send a replacement or issue a full refund.
                        </p>
                    </div>

                    {{-- Customs & Duties --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">4. Customs, Duties & Import Taxes</h2>
                        <p class="privacy__policy--content__desc">
                            International orders may be subject to customs inspection and import duties,
                            taxes, or fees imposed by your country's government upon arrival. These
                            charges are entirely outside our control and are the sole responsibility
                            of the customer. We are unable to predict, estimate, or cover these costs
                            on your behalf.
                        </p>
                        <p class="privacy__policy--content__desc">
                            If a package is held by customs and subsequently abandoned or returned to
                            us due to unpaid duties or failure to collect, we are unable to offer a
                            refund on shipping costs. The cost of the items may be refunded at our
                            discretion once the package has been returned and inspected.
                        </p>
                        <p class="privacy__policy--content__desc">
                            We declare all packages accurately on customs documentation and are legally
                            required to state the true value and contents of each shipment. We are
                            unable to mark packages as "gifts" or under-declare their value upon request.
                        </p>
                    </div>

                    {{-- Physical Return Process --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">5. Physical Return of Items</h2>
                        <p class="privacy__policy--content__desc">
                            In most cases involving damaged, defective, or incorrect international orders,
                            we will not require you to physically return the item to us due to the
                            prohibitive cost of international return shipping. Instead, photographic
                            evidence will be sufficient for us to process your claim.
                        </p>
                        <p class="privacy__policy--content__desc">
                            In exceptional circumstances where a physical return is required, our team
                            will communicate this clearly and provide you with a prepaid return shipping
                            label if the fault lies entirely with us. Do not send any items back to us
                            without written confirmation from our team, as unrequested returns may
                            not be processed or refunded.
                        </p>
                    </div>

                    {{-- Return Shipping Costs --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">6. International Return Shipping Costs</h2>
                        <p class="privacy__policy--content__desc">
                            Where a physical return is authorised and the fault lies with us (damaged,
                            defective, or incorrect item), we will cover the cost of return shipping
                            by providing a prepaid label or reimbursing a reasonable return shipping
                            cost upon submission of a receipt.
                        </p>
                        <p class="privacy__policy--content__desc">
                            In all other cases, any return shipping costs incurred internationally are
                            the sole responsibility of the customer. Original outbound shipping fees
                            are non-refundable. We strongly recommend using a tracked and insured
                            shipping service for any authorised returns, as we cannot be held
                            responsible for items lost during return transit.
                        </p>
                    </div>

                    {{-- Refund Process --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">7. International Refund Processing</h2>
                        <p class="privacy__policy--content__desc">
                            Once your international return or refund claim has been approved, refunds
                            will be issued back to your original payment method. Please allow
                            <strong>7 to 14 business days</strong> for the refund to appear, as
                            international payment processing can take longer than domestic transactions
                            depending on your bank, card provider, or PayPal account.
                        </p>
                        <p class="privacy__policy--content__desc">
                            Please note that currency exchange fluctuations may mean the refunded
                            amount appears slightly different from the original charge when converted
                            to your local currency. We refund the exact amount charged in USD and are
                            not responsible for exchange rate differences.
                        </p>
                    </div>

                    {{-- Non-Eligible --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">8. Non-Eligible International Claims</h2>
                        <p class="privacy__policy--content__desc">
                            We are unable to process a return or refund for international orders in
                            the following situations:
                            <br><br>
                            The claim is made more than 14 days after the confirmed delivery date.<br>
                            The order was not collected from a local post office or delivery depot
                            and was subsequently returned.<br>
                            An incorrect or incomplete delivery address was provided at checkout.<br>
                            The package was refused at the border due to local import restrictions
                            on books or printed materials in your country.<br>
                            Delays caused by customs, public holidays, or natural events beyond
                            our control.<br>
                            Change of mind or accidental purchase after the order has been dispatched.
                        </p>
                    </div>

                    {{-- Tips for International Customers --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">9. Tips for International Customers</h2>
                        <p class="privacy__policy--content__desc">
                            To ensure the smoothest possible experience when ordering internationally,
                            we recommend the following:
                            <br><br>
                            Double-check your full delivery address — including postcode, city, and
                            country — before completing checkout.<br><br>
                            Research your country's import duties and customs regulations for books
                            and printed materials before placing your order.<br><br>
                            Choose a tracked shipping method where available so you can monitor your
                            delivery and act quickly if there is an issue.<br><br>
                            Contact us before ordering if you have any questions about shipping
                            availability, estimated delivery times, or product details.
                        </p>
                    </div>

                    {{-- Policy Changes --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">10. Changes to This Policy</h2>
                        <p class="privacy__policy--content__desc">
                            We reserve the right to update this International Returns Policy at any
                            time. Changes will be published on this page with a revised "Last updated"
                            date. We recommend reviewing this policy before placing an international
                            order to ensure you are aware of the current terms.
                        </p>
                    </div>

                    {{-- Contact --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">11. Contact Us</h2>
                        <p class="privacy__policy--content__desc">
                            If you have a question about an international order, a delivery concern,
                            or need to raise a return or refund claim, please reach out to us —
                            we are always happy to help.
                            <br><br>
                            <strong>Nicole Murray</strong><br>
                            Email: <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a><br>
                            Website: <a href="{{ url('/') }}">{{ url('/') }}</a>
                            <br><br>
                            Please include your order number and a brief description of your issue
                            in your first message so we can assist you as quickly as possible.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
