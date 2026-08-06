@extends('frontend.customer.dashboard')
@section('customer_title', 'Complete Payment')
@section('customer_contents')

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row gy-4 justify-content-center">
        <div class="col-lg-7">
            <div class="dashboard-card">
                <h6 class="title mb-24">Complete Your One-Time Payment</h6>

                @if($customer->payment_status === 'approved')
                    <div class="alert alert-success mb-0">
                        Your payment is already verified — all downloads are unlocked. <a href="{{ route('customer.dashboard') }}" class="link text-decoration-underline">Go to Dashboard</a>
                    </div>
                @else
                    <div class="alert alert-info mb-4">
                        <strong>Amount: {{ number_format($site_settings_info->registration_fee ?? 0, 2) }}৳</strong><br>
                        Send Money via bKash to <strong>{{ $site_settings_info->bkash_merchant_number ?? 'N/A' }}</strong>,
                        then enter your bKash number and Transaction ID below to unlock all downloads instantly.
                    </div>

                    <form action="{{ route('customer.payment.submit') }}" method="POST">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <label for="bkash_number" class="form-label mb-2 fw-600">Your bKash Number</label>
                                <input type="text" name="bkash_number" class="common-input border" id="bkash_number" value="{{ old('bkash_number') }}" placeholder="01XXXXXXXXX" required>
                            </div>
                            <div class="col-md-6">
                                <label for="bkash_transaction_id" class="form-label mb-2 fw-600">bKash Transaction ID</label>
                                <input type="text" name="bkash_transaction_id" class="common-input border" id="bkash_transaction_id" value="{{ old('bkash_transaction_id') }}" placeholder="e.g. 9J7Z3XY1AB" style="text-transform:uppercase" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-main pill px-4">Verify Payment</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

@endsection
