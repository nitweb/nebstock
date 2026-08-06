@extends('frontend.customer.dashboard')
@section('customer_title', 'Complete Payment')
@section('customer_contents')

    <div class="dashboard-body__content">
        <div class="row gy-4">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                @endif

                <div class="flx-between gap-2 mb-3">
                    <h6 class="mb-0">Complete Your One-Time Payment</h6>
                </div>

                <div class="card common-card border border-gray-five">
                    <div class="card-body">
                        <div class="text-center py-4">
                            @if($customer->payment_status === 'approved')
                                <div class="alert alert-success mb-0">
                                    Your payment is already verified — all downloads are unlocked.
                                    <a href="{{ route('customer.dashboard') }}" class="link text-decoration-underline">Go to Dashboard</a>
                                </div>
                            @else
                                <p class="text-body mb-24">
                                    Amount: <strong class="text-main">{{ number_format($site_settings_info->registration_fee ?? 0, 2) }}৳</strong>
                                </p>
                                <form action="{{ route('customer.payment.bkash.initiate') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn px-5 py-3" style="background:#E2136E;color:#fff;border-radius:8px;font-weight:600;border:none;">
                                        <img src="{{ asset('frontend/assets/images/logo/bkash-logo-white.png') }}" alt="bKash" style="height:20px;vertical-align:middle;margin-right:8px;" onerror="this.style.display='none'">
                                        Pay with bKash
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection