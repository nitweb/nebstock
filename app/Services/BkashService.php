<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BkashService
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;
    protected string $appKey;
    protected string $appSecret;

    public function __construct()
    {
        $this->baseUrl   = config('bkash.base_url');
        $this->username  = config('bkash.username');
        $this->password  = config('bkash.password');
        $this->appKey    = config('bkash.app_key');
        $this->appSecret = config('bkash.app_secret');
    }

    /* ===== Step 1: Grant Token (cached ~55 min) ===== */
    public function getToken(): ?string
    {
        return Cache::remember('bkash_id_token', 3300, function () {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'username'     => $this->username,
                'password'     => $this->password,
            ])->post("{$this->baseUrl}/tokenized/checkout/token/grant", [
                'app_key'    => $this->appKey,
                'app_secret' => $this->appSecret,
            ]);

            if ($response->failed()) {
                Log::error('bKash grant token failed', $response->json() ?? []);
                return null;
            }

            return $response->json('id_token');
        });
    } // End Method

    /* ===== Step 2: Create Payment ===== */
    public function createPayment(float $amount, string $invoiceNumber, string $callbackUrl): ?array
    {
        $token = $this->getToken();
        if (!$token) {
            return null;
        }

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => $token,
            'X-App-Key'     => $this->appKey,
        ])->post("{$this->baseUrl}/tokenized/checkout/create", [
            'mode'                  => '0011',
            'payerReference'        => ' ',
            'callbackURL'           => $callbackUrl,
            'amount'                => number_format($amount, 2, '.', ''),
            'currency'              => 'BDT',
            'intent'                => 'sale',
            'merchantInvoiceNumber' => $invoiceNumber,
        ]);

        if ($response->failed()) {
            Log::error('bKash create payment failed', $response->json() ?? []);
            return null;
        }

        return $response->json();
    } // End Method

    /* ===== Step 3: Execute Payment (called from callback) ===== */
    public function executePayment(string $paymentID): ?array
    {
        $token = $this->getToken();
        if (!$token) {
            return null;
        }

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => $token,
            'X-App-Key'     => $this->appKey,
        ])->post("{$this->baseUrl}/tokenized/checkout/execute/{$paymentID}");

        if ($response->failed()) {
            Log::error('bKash execute payment failed', $response->json() ?? []);
            return null;
        }

        return $response->json();
    } // End Method

    /* ===== Query Payment (status check / verification) ===== */
    public function queryPayment(string $paymentID): ?array
    {
        $token = $this->getToken();
        if (!$token) {
            return null;
        }

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => $token,
            'X-App-Key'     => $this->appKey,
        ])->post("{$this->baseUrl}/tokenized/checkout/payment/status", [
            'paymentID' => $paymentID,
        ]);

        if ($response->failed()) {
            Log::error('bKash query payment failed', $response->json() ?? []);
            return null;
        }

        return $response->json();
    } // End Method
}