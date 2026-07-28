<?php

namespace App\Services;

class ShippingService
{
    /**
     * Shipping rates per country.
     * Economy (USPS) = US only, PO Box required.
     * FedEx & UPS available for all listed countries.
     */
    private static array $rates = [
        'US' => [
            'economy' => ['label' => 'Economy (USPS)', 'cost' => 5.0, 'po_box_only' => true],
            'fedex' => ['label' => 'FedEx', 'cost' => 12.0, 'po_box_only' => false],
            'ups' => ['label' => 'UPS', 'cost' => 14.0, 'po_box_only' => false],
        ],
        'BD' => [
            'fedex' => ['label' => 'FedEx', 'cost' => 8.0, 'po_box_only' => false],
            'ups' => ['label' => 'UPS', 'cost' => 10.0, 'po_box_only' => false],
        ],
        'IN' => [
            'fedex' => ['label' => 'FedEx', 'cost' => 9.0, 'po_box_only' => false],
            'ups' => ['label' => 'UPS', 'cost' => 11.0, 'po_box_only' => false],
        ],
        'GB' => [
            'fedex' => ['label' => 'FedEx', 'cost' => 15.0, 'po_box_only' => false],
            'ups' => ['label' => 'UPS', 'cost' => 18.0, 'po_box_only' => false],
        ],
        'NL' => [
            'fedex' => ['label' => 'FedEx', 'cost' => 13.0, 'po_box_only' => false],
            'ups' => ['label' => 'UPS', 'cost' => 16.0, 'po_box_only' => false],
        ],
        'AF' => [
            'fedex' => ['label' => 'FedEx', 'cost' => 20.0, 'po_box_only' => false],
            'ups' => ['label' => 'UPS', 'cost' => 25.0, 'po_box_only' => false],
        ],
        'AL' => [
            'fedex' => ['label' => 'FedEx', 'cost' => 14.0, 'po_box_only' => false],
            'ups' => ['label' => 'UPS', 'cost' => 17.0, 'po_box_only' => false],
        ],
        'AG' => [
            'fedex' => ['label' => 'FedEx', 'cost' => 16.0, 'po_box_only' => false],
            'ups' => ['label' => 'UPS', 'cost' => 19.0, 'po_box_only' => false],
        ],
    ];

    /**
     * Get all shipping methods for a country as a flat array (for JSON responses).
     */
    public static function getMethodsForCountry(string $country): array
    {
        $methods = self::$rates[$country] ?? [];

        return array_map(
            function (string $key, array $data) {
                return [
                    'value' => $key,
                    'label' => $data['label'],
                    'cost' => $data['cost'],
                    'po_box_only' => $data['po_box_only'],
                ];
            },
            array_keys($methods),
            $methods,
        );
    }

    /**
     * Get cost for a specific country + method.
     */
    public static function getCost(string $country, string $method): float
    {
        return (float) (self::$rates[$country][$method]['cost'] ?? 0);
    }

    /**
     * Validate PO Box rule and method availability.
     * Returns ['valid' => bool, 'message' => string].
     */
    public static function validate(string $country, string $method, string $address): array
    {
        // Method not available for country
        if (!isset(self::$rates[$country][$method])) {
            return [
                'valid' => false,
                'message' => "Shipping method '{$method}' is not available for the selected country.",
            ];
        }

        // PO Box check: Economy/USPS in US requires PO Box
        if ($country === 'US' && $method === 'economy') {
            $isPoBox = (bool) preg_match('/\b(P\.?\s*O\.?\s*Box|Post\s*Office\s*Box)\b/i', $address);
            if (!$isPoBox) {
                return [
                    'valid' => false,
                    'message' => 'Economy (USPS) shipping is only available for PO Box addresses in the US. Please enter a valid PO Box or choose FedEx / UPS.',
                ];
            }
        }

        return ['valid' => true, 'message' => ''];
    }
}
