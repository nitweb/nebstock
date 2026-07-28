<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stripe Mode
    |--------------------------------------------------------------------------
    | 'test' → testing with Stripe test keys
    | 'live' → production
    |
    | .env এ STRIPE_MODE=test অথবা STRIPE_MODE=live set করো
    */

    'mode' => env('STRIPE_MODE', 'test'),

    /*
    |--------------------------------------------------------------------------
    | Publishable Key (Frontend JS এ use হয়)
    |--------------------------------------------------------------------------
    */
    'publishable_key' => env('STRIPE_MODE', 'test') === 'live'
        ? env('STRIPE_LIVE_PUBLISHABLE_KEY')
        : env('STRIPE_TEST_PUBLISHABLE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Secret Key (Server-side only)
    |--------------------------------------------------------------------------
    */
    'secret_key' => env('STRIPE_MODE', 'test') === 'live'
        ? env('STRIPE_LIVE_SECRET_KEY')
        : env('STRIPE_TEST_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Secret
    |--------------------------------------------------------------------------
    | Stripe Dashboard → Webhooks → Signing Secret
    */
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    | Stripe uses lowercase currency codes.
    | UK client → gbp
    */
    'currency' => env('STRIPE_CURRENCY', 'usd'),
];
