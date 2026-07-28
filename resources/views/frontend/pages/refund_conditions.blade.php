@extends('frontend.dashboard')
@section('frontend_title', 'Refund Conditions')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Refund Conditions</h1>
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
                        <h2 class="privacy__policy--content__title">Refund Conditions</h2>
                        <p class="privacy__policy--content__desc">
                            Last updated: {{ date('F d, Y') }}<br>
                            At <strong>Nicole Murray</strong>, we want every customer to feel confident
                            and informed when shopping with us. This page sets out the specific conditions
                            under which a refund may be requested, approved, or declined. Please read
                            these conditions carefully before submitting a refund request. If you have
                            any questions, our team is always happy to assist.
                        </p>
                    </div>

                    {{-- General Conditions --}}
                    <div class="privacy__policy--content section_2">
                        <h2 class="privacy__policy--content__title">1. General Refund Conditions</h2>
                        <p class="privacy__policy--content__desc">
                            Refunds at Nicole Murray are not automatic — each request is reviewed
                            individually and assessed against the conditions outlined on this page.
                            Submitting a refund request does not guarantee that a refund will be
                            issued. Our team will always aim to respond to refund requests within
                            <strong>3 business days</strong> and will communicate our decision
                            clearly along with any next steps.
                        </p>
                        <p class="privacy__policy--content__desc">
                            By placing an order on our website, you acknowledge that you have read
                            and understood these refund conditions and agree to be bound by them.
                        </p>
                    </div>

                    {{-- Eligible Conditions --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">2. Conditions Under Which a Refund May Be Approved</h2>

                        <h3 class="privacy__policy--content__subtitle">Item Arrived Damaged</h3>
                        <p class="privacy__policy--content__desc">
                            A refund or replacement may be approved if your item arrives with physical
                            damage caused during transit — including torn covers, broken spines, crushed
                            packaging, or water damage. To be eligible, you must:
                            <br><br>
                            Contact us within <strong>7 days</strong> of the confirmed delivery date
                            (or within <strong>14 days</strong> for international orders).<br>
                            Provide clear photographs of both the damaged item and the outer packaging
                            it arrived in.<br>
                            Include your order number in your request.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Item Is Defective</h3>
                        <p class="privacy__policy--content__desc">
                            A refund or replacement may be approved if the item has a manufacturing
                            defect present at the time of dispatch — such as missing or misprinted pages,
                            incorrect binding, or significant print quality issues. You must notify us
                            within <strong>7 days</strong> of delivery (or <strong>14 days</strong> for
                            international orders) and provide photographic evidence clearly showing
                            the defect.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Wrong Item Received</h3>
                        <p class="privacy__policy--content__desc">
                            If you received an item that does not match what you ordered — including
                            the wrong title, wrong edition, or wrong quantity — a full refund or
                            free replacement will be offered. Please contact us within
                            <strong>7 days</strong> of delivery (or <strong>14 days</strong> for
                            international orders) and include a photograph of the item received
                            alongside your order number.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Order Never Arrived (Confirmed Lost)</h3>
                        <p class="privacy__policy--content__desc">
                            If your order has not arrived within the maximum estimated delivery
                            window for your shipping method and country, and a courier investigation
                            confirms the package is lost, a full refund or replacement will be
                            offered. Please allow the following timeframes before raising a
                            lost parcel claim:
                            <br><br>
                            <strong>Domestic Standard:</strong> 15 business days from dispatch.<br>
                            <strong>Domestic Express:</strong> 7 business days from dispatch.<br>
                            <strong>International Standard:</strong> 30 business days from dispatch.<br>
                            <strong>International Economy:</strong> 45 business days from dispatch.<br>
                            <strong>International Express:</strong> 15 business days from dispatch.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Order Cancelled Before Dispatch</h3>
                        <p class="privacy__policy--content__desc">
                            If you contact us to cancel your order before it has been dispatched,
                            a full refund will be issued. Once an order has been dispatched, it
                            can no longer be cancelled and our standard return and refund conditions
                            will apply. Please contact us as soon as possible at
                            <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a>
                            if you wish to cancel.
                        </p>
                    </div>

                    {{-- Ineligible Conditions --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">3. Conditions Under Which a Refund Will Not Be Approved</h2>
                        <p class="privacy__policy--content__desc">
                            We are unable to approve a refund under the following circumstances:
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Change of Mind</h3>
                        <p class="privacy__policy--content__desc">
                            We do not offer refunds for change of mind, accidental purchases, or
                            because you found the same item at a lower price elsewhere after placing
                            your order. We strongly encourage you to review all product details
                            and your cart carefully before completing checkout.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Request Made Outside the Eligible Window</h3>
                        <p class="privacy__policy--content__desc">
                            Refund requests submitted more than 7 days after the confirmed delivery
                            date for domestic orders, or more than 14 days for international orders,
                            will not be considered unless exceptional circumstances apply and are
                            communicated to us clearly at the time of the request.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Damage Caused After Delivery</h3>
                        <p class="privacy__policy--content__desc">
                            We are unable to refund items that have been damaged after delivery
                            through mishandling, exposure to water or heat, or normal wear and
                            use. Refunds are only applicable to damage that was clearly present
                            upon arrival and documented promptly with photographic evidence.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Incorrect Address Provided by Customer</h3>
                        <p class="privacy__policy--content__desc">
                            If an order fails to arrive or is returned to us because an incorrect,
                            incomplete, or undeliverable address was provided at checkout, we are
                            not liable and a refund will not be automatically issued. We will work
                            with you to arrange reshipment at your cost or offer a partial refund
                            at our discretion once the package is returned to us.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Delays Beyond Our Control</h3>
                        <p class="privacy__policy--content__desc">
                            Refunds will not be issued for delivery delays caused by events outside
                            our control, including but not limited to customs processing, public
                            holidays, severe weather, courier backlogs, or industrial action.
                            We will always assist you in monitoring and investigating delayed
                            shipments, but cannot guarantee refunds for delays alone.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Packages Held or Seized by Customs</h3>
                        <p class="privacy__policy--content__desc">
                            We are not responsible for international packages held, delayed, or
                            seized by customs authorities in the destination country. Import duties,
                            taxes, or compliance issues in your country are outside our control
                            and do not qualify for a refund from us.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Final Sale Items</h3>
                        <p class="privacy__policy--content__desc">
                            Items purchased during clearly marked final sale or clearance events
                            are not eligible for a refund under any circumstances, except in the
                            case of a manufacturing defect or incorrect item being sent.
                        </p>
                    </div>

                    {{-- Partial Refunds --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">4. Partial Refunds</h2>
                        <p class="privacy__policy--content__desc">
                            In some circumstances, a partial refund may be offered rather than a
                            full refund. This may apply when only part of an order is affected by
                            an issue, when an item is returned in a condition different from how
                            it was dispatched, or when the issue reported is minor and does not
                            significantly impact the use or enjoyment of the product. The amount
                            of any partial refund will be determined by our team on a case-by-case
                            basis and communicated to you clearly before processing.
                        </p>
                    </div>

                    {{-- Refund Method --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">5. How Refunds Are Issued</h2>
                        <p class="privacy__policy--content__desc">
                            All approved refunds are issued to the original payment method used
                            at the time of purchase. We do not issue refunds via a different
                            payment method, store credit, or cash under any circumstances.
                            <br><br>
                            <strong>PayPal:</strong> Refunds are typically processed within
                            3 to 5 business days and will appear in your PayPal account or
                            linked bank account.<br><br>
                            <strong>Bank Transfer:</strong> Refunds are returned to the originating
                            bank account. Please ensure you provide your bank details when
                            submitting your refund request. Processing may take 5 to 10
                            business days.<br><br>
                            <strong>Cash on Delivery:</strong> Refunds for COD orders will be
                            processed via bank transfer. Please provide your bank account
                            details when contacting us.
                        </p>
                    </div>

                    {{-- Shipping Refunds --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">6. Refunds on Shipping Costs</h2>
                        <p class="privacy__policy--content__desc">
                            Original shipping costs are non-refundable unless the reason for the
                            refund is directly due to our error — such as sending a damaged,
                            defective, or incorrect item. In all other approved refund cases,
                            only the item value will be refunded and the original shipping fee
                            will be retained.
                        </p>
                    </div>

                    {{-- Coupon & Discount Refunds --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">7. Refunds Involving Discount Codes or Coupons</h2>
                        <p class="privacy__policy--content__desc">
                            If a discount code or coupon was applied to an order that is subsequently
                            refunded, the refund will reflect the actual amount paid after the discount
                            was applied — not the original pre-discount price. Discount codes and
                            coupons used in a refunded order will not be reinstated or reissued
                            unless at our sole discretion.
                        </p>
                    </div>

                    {{-- Timeline --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">8. Refund Request Timeline Summary</h2>
                        <p class="privacy__policy--content__desc">
                            For your convenience, here is a summary of the key timeframes that
                            apply to refund requests:
                            <br><br>
                            <strong>Domestic orders — damaged, defective, or incorrect:</strong>
                            Contact us within 7 days of delivery.<br><br>
                            <strong>International orders — damaged, defective, or incorrect:</strong>
                            Contact us within 14 days of delivery.<br><br>
                            <strong>Lost domestic orders:</strong> Contact us after the maximum
                            estimated delivery window has passed.<br><br>
                            <strong>Lost international orders:</strong> Contact us after 30 to 45
                            business days from dispatch, depending on shipping method.<br><br>
                            <strong>Cancellations:</strong> Contact us before dispatch for a
                            full refund. Post-dispatch cancellations are not accepted.<br><br>
                            <strong>Our response time:</strong> We aim to respond to all refund
                            requests within 3 business days.<br><br>
                            <strong>Refund processing time:</strong> 3 to 10 business days
                            after approval, depending on your payment method.
                        </p>
                    </div>

                    {{-- How to Request --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">9. How to Submit a Refund Request</h2>
                        <p class="privacy__policy--content__desc">
                            To submit a refund request, please email us at
                            <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a>
                            with the following details:
                            <br><br>
                            Your full name and the email address used to place the order.<br>
                            Your order number (found in your confirmation email).<br>
                            A clear description of the issue and the reason for your refund request.<br>
                            Photographs of the item and packaging where applicable.<br>
                            Your preferred resolution — refund or replacement.
                            <br><br>
                            Incomplete requests may experience delays. Please do not return
                            any items to us without first receiving written confirmation
                            from our team authorising the return.
                        </p>
                    </div>

                    {{-- Policy Changes --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">10. Changes to These Refund Conditions</h2>
                        <p class="privacy__policy--content__desc">
                            We reserve the right to update or amend these Refund Conditions at
                            any time. Any changes will be published on this page with a revised
                            "Last updated" date. The conditions in effect at the time your order
                            was placed will apply to that order.
                        </p>
                    </div>

                    {{-- Contact --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">11. Contact Us</h2>
                        <p class="privacy__policy--content__desc">
                            If you have any questions about our refund conditions or need help
                            with an existing request, please get in touch — we are always here
                            to help.
                            <br><br>
                            <strong>Nicole Murray</strong><br>
                            Email: <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a><br>
                            Website: <a href="{{ url('/') }}">{{ url('/') }}</a>
                            <br><br>
                            Please include your order number and a brief description of your
                            issue in your first message so we can assist you as efficiently
                            as possible.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
