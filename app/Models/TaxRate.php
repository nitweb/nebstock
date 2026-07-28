<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TaxRate extends Model
{
    protected $guarded = [];

    protected $casts = [
        'fetched_at' => 'datetime',
        'is_active'  => 'boolean',
        'rate'       => 'float',
    ];

    public static function getRateForCountry(string $countryCode): float
    {
        $code = strtoupper($countryCode);

        // ── 1. DB cache check (24 ঘণ্টার মধ্যে fetch হলে use করো) ──
        $existing = static::where('country_code', $code)
            ->where('is_active', true)
            ->first();

        if ($existing && $existing->fetched_at && $existing->fetched_at->gt(now()->subHours(24))) {
            return (float) $existing->rate;
        }

        // ── 2. VATcomply API (EU + GB) ──
        $euCountries = [
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI',
            'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT',
            'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK', 'GB',
        ];

        // EU official code EL → VATcomply uses GR for Greece
        $apiCode = $code === 'EL' ? 'GR' : $code;

        if (in_array($apiCode, $euCountries)) {
            try {
                $response = Http::timeout(5)
                    ->get("https://api.vatcomply.com/rates?country_code={$apiCode}");

                if ($response->successful()) {
                    $data = $response->json();
                    $rate = (float) ($data['rates']['standard'] ?? 0);

                    if ($rate > 0) {
                        static::updateOrCreate(
                            ['country_code' => $code],
                            [
                                'country_name' => $data['country_name'] ?? $code,
                                'rate'         => $rate,
                                'source'       => 'api',
                                'is_active'    => true,
                                'fetched_at'   => now(),
                            ]
                        );
                        return $rate;
                    }
                }
            } catch (\Exception $e) {
                Log::warning("VATcomply API failed for {$code}: " . $e->getMessage());
            }
        }

        // ── 3. Static Fallback ──
        $staticRates = [
            // ── EU ──
            'AT' => 20.00,  // Austria
            'BE' => 21.00,  // Belgium
            'BG' => 20.00,  // Bulgaria
            'CY' => 19.00,  // Cyprus
            'CZ' => 21.00,  // Czech Republic
            'DE' => 19.00,  // Germany
            'DK' => 25.00,  // Denmark
            'EE' => 22.00,  // Estonia
            'EL' => 24.00,  // Greece (EU code)
            'GR' => 24.00,  // Greece (ISO code)
            'ES' => 21.00,  // Spain
            'FI' => 24.00,  // Finland
            'FR' => 20.00,  // France
            'HR' => 25.00,  // Croatia
            'HU' => 27.00,  // Hungary
            'IE' => 23.00,  // Ireland
            'IT' => 22.00,  // Italy
            'LT' => 21.00,  // Lithuania
            'LU' => 17.00,  // Luxembourg
            'LV' => 21.00,  // Latvia
            'MT' => 18.00,  // Malta
            'NL' => 21.00,  // Netherlands
            'PL' => 23.00,  // Poland
            'PT' => 23.00,  // Portugal
            'RO' => 19.00,  // Romania
            'SE' => 25.00,  // Sweden
            'SI' => 22.00,  // Slovenia
            'SK' => 20.00,  // Slovakia
            // ── Non-EU ──
            'GB' => 20.00,  // United Kingdom
            'BD' => 0.00,   // Bangladesh
            'IN' => 18.00,  // India GST
            'US' => 0.00,   // US (state-wise, exclude)
            'CA' => 5.00,   // Canada GST
            'AU' => 10.00,  // Australia GST
            'SG' => 9.00,   // Singapore GST
            'AE' => 5.00,   // UAE VAT
            'SA' => 15.00,  // Saudi Arabia VAT
            'PK' => 17.00,  // Pakistan GST
            'NG' => 7.50,   // Nigeria VAT
        ];

        $rate = (float) ($staticRates[$code] ?? 0);

        static::updateOrCreate(
            ['country_code' => $code],
            [
                'country_name' => $code,
                'rate'         => $rate,
                'source'       => 'manual',
                'is_active'    => true,
                'fetched_at'   => now(),
            ]
        );

        return $rate;
    }
}