<?php

namespace App\Http\Controllers;

use App\Models\SiteSettings;
use App\Services\BkashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BkashDemoController extends Controller
{
    protected BkashService $bkash;

    public function __construct(BkashService $bkash)
    {
        $this->bkash = $bkash;
    }

    /* ===== Step 1: "Pay with bKash" -> create payment on bKash sandbox, redirect user there ===== */
    public function initiate(Request $request)
    {
        $customer = Auth::guard('user')->user();

        if ($customer->payment_status === 'approved') {
            return redirect()->route('customer.dashboard');
        }

        $site_settings = SiteSettings::first();
        $amount = (float) ($site_settings->registration_fee ?? 0);

        if ($amount <= 0) {
            return back()->with('error', 'Registration fee not configured.');
        }

        $invoiceNumber = 'NEB-' . $customer->id . '-' . now()->format('YmdHis');
        $callbackUrl   = route('customer.payment.bkash.callback');

        $payment = $this->bkash->createPayment($amount, $invoiceNumber, $callbackUrl);

        if (!$payment || empty($payment['bkashURL'])) {
            Log::error('bKash createPayment returned no bkashURL', $payment ?? []);
            return back()->with('error', 'Could not connect to bKash right now. Please try again.');
        }

        session([
            'bkash_payment_id' => $payment['paymentID'],
            'bkash_invoice'    => $invoiceNumber,
            'bkash_amount'     => $amount,
        ]);

        // Redirect user to bKash's own hosted sandbox checkout page
        return redirect()->away($payment['bkashURL']);
    } // End Method

    /* ===== Step 2: bKash redirects back here after user pays/cancels on their page ===== */
    public function callback(Request $request)
    {
        $customer  = Auth::guard('user')->user();
        $paymentID = $request->query('paymentID') ?? session('bkash_payment_id');
        $status    = $request->query('status'); // success | failure | cancel

        if ($status !== 'success' || !$paymentID) {
            session()->forget(['bkash_payment_id', 'bkash_invoice', 'bkash_amount']);
            return redirect()->route('customer.payment')->with('error', 'Payment was not completed (' . ($status ?? 'cancelled') . ').');
        }

        $result = $this->bkash->executePayment($paymentID);

        if (!$result || ($result['transactionStatus'] ?? null) !== 'Completed') {
            Log::error('bKash execute payment not completed', $result ?? []);
            session()->forget(['bkash_payment_id', 'bkash_invoice', 'bkash_amount']);
            return redirect()->route('customer.payment')->with('error', 'Payment verification failed. Please try again.');
        }

        $customer->update([
            'bkash_number'         => $result['customerMsisdn'] ?? null,
            'bkash_transaction_id' => $result['trxID'] ?? $paymentID,
            'payment_amount'       => $result['amount'] ?? session('bkash_amount'),
            'payment_status'       => 'approved',
            'payment_approved_at'  => now(),
        ]);

        session()->forget(['bkash_payment_id', 'bkash_invoice', 'bkash_amount']);

        return redirect()->route('customer.dashboard')->with(
            'success',
            'Payment Successful! bKash Transaction ID: ' . ($result['trxID'] ?? $paymentID)
        );
    } // End Method
}