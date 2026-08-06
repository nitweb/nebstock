<?php

return [

    // Toggle sandbox / live
    'sandbox' => env('BKASH_SANDBOX', true),

    'base_url' => env('BKASH_SANDBOX', true)
        ? 'https://tokenized.sandbox.bka.sh/v1.2.0-beta'
        : 'https://tokenized.pay.bka.sh/v1.2.0-beta',

    // Public bKash sandbox test credentials (Tokenized Checkout)
    // Replace with real credentials in .env when moving to production.
    'username'   => env('BKASH_USERNAME', 'sandboxTokenizedUser02'),
    'password'   => env('BKASH_PASSWORD', 'sandboxTokenizedUser02@12345'),
    'app_key'    => env('BKASH_APP_KEY', '4f6o0cjiki2rfm34kfdadl1eqq'),
    'app_secret' => env('BKASH_APP_SECRET', '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b'),

    'callback_url' => env('BKASH_CALLBACK_URL'), // filled at runtime with route() if empty

];