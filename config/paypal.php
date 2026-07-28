<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PayPal Mode
    |--------------------------------------------------------------------------
    | 'sandbox' → testing
    | 'live'    → production (UK client এর জন্য)
    |
    | .env এ PAYPAL_MODE=sandbox অথবা PAYPAL_MODE=live set করো
    */

    'mode' => env('PAYPAL_MODE', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    | .env এ set করো:
    |   PAYPAL_SANDBOX_CLIENT_ID=...
    |   PAYPAL_SANDBOX_CLIENT_SECRET=...
    |   PAYPAL_LIVE_CLIENT_ID=...
    |   PAYPAL_LIVE_CLIENT_SECRET=...
    */

    'client_id' => env('PAYPAL_MODE', 'sandbox') === 'live'
        ? env('PAYPAL_LIVE_CLIENT_ID')
        : env('PAYPAL_SANDBOX_CLIENT_ID'),

    'client_secret' => env('PAYPAL_MODE', 'sandbox') === 'live'
        ? env('PAYPAL_LIVE_CLIENT_SECRET')
        : env('PAYPAL_SANDBOX_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    */

    'base_url' => env('PAYPAL_MODE', 'sandbox') === 'live'
        ? 'https://api-m.paypal.com'
        : 'https://api-m.sandbox.paypal.com',

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    | UK client → GBP
    | USD ও চলবে যদি দরকার হয়
    */

    'currency' => env('PAYPAL_CURRENCY', 'GBP'),

];
