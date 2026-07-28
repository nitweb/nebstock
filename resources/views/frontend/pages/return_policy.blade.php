@extends('frontend.dashboard')
@section('frontend_title', 'Return Policy')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Return Policy</h1>
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
                        <h2 class="privacy__policy--content__title">Return Policy</h2>
                        <p class="privacy__policy--content__desc">
                            Last updated: {{ date('F d, Y') }}<br>
                            At <strong>Nicole Murray</strong>, we take pride in the quality of every order
                            we send out. We understand that sometimes things do not go as expected, and we
                            want to make sure you feel confident shopping with us. Please read our Return
                            Policy carefully so you know exactly what to expect if something goes wrong
                            with your order.
                        </p>
                    </div>

                    {{-- All Sales Final --}}
                    <div class="privacy__policy--content section_2">
                        <h2 class="privacy__policy--content__title">1. All Sales Are Final</h2>
                        <p class="privacy__policy--content__desc">
                            Due to the nature of our products, we do not accept returns or exchanges
                            for change of mind, accidental purchases, or if you simply no longer want
                            the item. We strongly encourage you to review your cart carefully before
                            completing your order. If you have any questions about a product before
                            purchasing, please contact us and we will be happy to help.
                        </p>
                    </div>

                    {{-- Eligible Returns --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">2. When We Do Accept Returns</h2>
                        <p class="privacy__policy--content__desc">
                            We will gladly assist you in the following circumstances:
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Damaged Items</h3>
                        <p class="privacy__policy--content__desc">
                            If your order arrives physically damaged — torn pages, broken spine, crushed
                            packaging, or any other damage that occurred during transit — we will replace
                            the item or issue a full refund. You must notify us within <strong>7 days</strong>
                            of receiving your order with photographic evidence of the damage.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Defective Items</h3>
                        <p class="privacy__policy--content__desc">
                            If a product is defective — such as missing pages, printing errors, or
                            manufacturing faults — please contact us within <strong>7 days</strong> of
                            delivery. We will assess the issue and offer a replacement or refund
                            at our discretion.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Incorrect Items</h3>
                        <p class="privacy__policy--content__desc">
                            If you received an item that is different from what you ordered — wrong title,
                            wrong edition, or wrong quantity — please contact us within <strong>7 days</strong>
                            of receiving your package. We will arrange for the correct item to be sent to
                            you at no additional cost, or issue a full refund if the correct item is
                            no longer available.
                        </p>

                        <h3 class="privacy__policy--content__subtitle">Lost Orders</h3>
                        <p class="privacy__policy--content__desc">
                            If your order has not arrived within the maximum estimated delivery window
                            for your chosen shipping method, please contact us so we can open an
                            investigation with the courier. If the package is confirmed as lost,
                            we will send a replacement or issue a refund. Please note that we are
                            not responsible for packages lost due to an incorrect or incomplete
                            delivery address provided at checkout.
                        </p>
                    </div>

                    {{-- How to Request --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">3. How to Request a Return or Refund</h2>
                        <p class="privacy__policy--content__desc">
                            To initiate a return or refund request, please email us at
                            <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a> with the
                            following information:
                            <br><br>
                            Your full name and email address used to place the order.<br>
                            Your order number (found in your confirmation email).<br>
                            A clear description of the issue.<br>
                            Photographs of the item and packaging where applicable (required for
                            damaged or defective claims).
                            <br><br>
                            We aim to respond to all return requests within <strong>3 business days</strong>.
                            Please do not return any items to us without receiving written confirmation
                            from our team first, as unauthorised returns may not be processed.
                        </p>
                    </div>

                    {{-- Refund Process --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">4. Refund Processing</h2>
                        <p class="privacy__policy--content__desc">
                            Once your return or refund request has been approved, refunds will be
                            processed back to your original payment method within
                            <strong>5 to 10 business days</strong>, depending on your bank or
                            payment provider. Shipping costs are non-refundable unless the return
                            is a result of our error (damaged, defective, or incorrect item).
                        </p>
                        <p class="privacy__policy--content__desc">
                            If your order was paid via Bank Transfer, refunds will be made to the
                            same bank account. Please ensure you provide your bank details when
                            submitting your refund request.
                        </p>
                    </div>

                    {{-- Non-Returnable --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">5. Non-Returnable Situations</h2>
                        <p class="privacy__policy--content__desc">
                            We are unable to process a return or refund in the following situations:
                            <br><br>
                            The request is made more than 7 days after delivery.<br>
                            The item shows signs of use, wear, or damage caused after receipt.<br>
                            The item was purchased during a final sale or clearance event clearly
                            marked as non-returnable.<br>
                            An incorrect delivery address was provided by the customer resulting
                            in non-delivery.<br>
                            The package was refused at delivery by the customer without prior
                            arrangement with us.
                        </p>
                    </div>

                    {{-- Exchanges --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">6. Exchanges</h2>
                        <p class="privacy__policy--content__desc">
                            We do not offer direct exchanges for change of mind. If you received a
                            damaged, defective, or incorrect item and would prefer a replacement over
                            a refund, please mention this in your return request and we will do our
                            best to accommodate you, subject to stock availability.
                        </p>
                    </div>

                    {{-- Bulk Orders --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">7. Bulk & Wholesale Orders</h2>
                        <p class="privacy__policy--content__desc">
                            Bulk and wholesale orders are subject to separate terms agreed upon at
                            the time of purchase. If you have a concern regarding a bulk order,
                            please contact us directly and we will work with you to find an
                            appropriate resolution.
                        </p>
                    </div>

                    {{-- Shipping Costs --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">8. Return Shipping Costs</h2>
                        <p class="privacy__policy--content__desc">
                            If a physical return of an item is required (as directed by our team),
                            we will cover the return shipping cost only in cases where the fault
                            lies with us — damaged, defective, or incorrect items. In all other
                            approved cases, return shipping costs are the responsibility of the
                            customer. We recommend using a trackable shipping service for any
                            returns, as we cannot be held responsible for items lost in transit
                            back to us.
                        </p>
                    </div>

                    {{-- Policy Changes --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">9. Changes to This Policy</h2>
                        <p class="privacy__policy--content__desc">
                            We reserve the right to update or amend this Return Policy at any time.
                            Any changes will be reflected on this page with a revised "Last updated"
                            date. We encourage you to review this policy before making a purchase
                            so you are always aware of our current terms.
                        </p>
                    </div>

                    {{-- Contact --}}
                    <div class="privacy__policy--content section_3">
                        <h2 class="privacy__policy--content__title">10. Contact Us</h2>
                        <p class="privacy__policy--content__desc">
                            If you have any questions about our Return Policy or need help with an
                            existing order, please do not hesitate to get in touch:
                            <br><br>
                            <strong>Nicole Murray</strong><br>
                            Email: <a href="mailto:info@nicolemurray.com">info@nicolemurray.com</a><br>
                            Website: <a href="{{ url('/') }}">{{ url('/') }}</a>
                            <br><br>
                            We are here to help and will always do our best to find a fair resolution
                            for every customer.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
