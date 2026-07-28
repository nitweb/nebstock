<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'discount'      => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total'         => 'decimal:2',
    ];

    // ── Status constants ──────────────────────────────────────────────────────
    const STATUS_PENDING    = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED    = 'shipped';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_CANCELLED  = 'cancelled';

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING    => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_SHIPPED    => 'Shipped',
            self::STATUS_DELIVERED  => 'Delivered',
            self::STATUS_CANCELLED  => 'Cancelled',
        ];
    }

    // ── Relations ─────────────────────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return static::statuses()[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'warning',
            'processing' => 'primary',
            'shipped'    => 'info',
            'delivered'  => 'success',
            'cancelled'  => 'danger',
            default      => 'secondary',
        };
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match ($this->payment_status ?? 'pending') {
            'paid'     => 'success',
            'failed'   => 'danger',
            'refunded' => 'warning',
            default    => 'secondary',
        };
    }

    // Shipping address aliases (DB stores: name, address, city, postal_code, country, company)
    public function getShippingNameAttribute(): ?string
    {
        return $this->name;
    }

    public function getShippingAddressAttribute(): ?string
    {
        return $this->address;
    }

    public function getShippingCityAttribute(): ?string
    {
        return $this->city;
    }

    public function getShippingPostalCodeAttribute(): ?string
    {
        return $this->postal_code;
    }

    public function getShippingCountryAttribute(): ?string
    {
        return $this->country;
    }

    public function getShippingCompanyAttribute(): ?string
    {
        return $this->company;
    }

    // discount_amount alias (DB column: discount)
    public function getDiscountAmountAttribute(): float
    {
        return (float) $this->discount;
    }

    public function getCountryNameAttribute(): string
    {
        $countries = [
            'AT' => 'Austria',
            'BE' => 'Belgium',
            'BG' => 'Bulgaria',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DE' => 'Germany',
            'DK' => 'Denmark',
            'EE' => 'Estonia',
            'EL' => 'Greece',
            'GR' => 'Greece',
            'ES' => 'Spain',
            'FI' => 'Finland',
            'FR' => 'France',
            'HR' => 'Croatia',
            'HU' => 'Hungary',
            'IE' => 'Ireland',
            'IT' => 'Italy',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'LV' => 'Latvia',
            'MT' => 'Malta',
            'NL' => 'Netherlands',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'RO' => 'Romania',
            'SE' => 'Sweden',
            'SI' => 'Slovenia',
            'SK' => 'Slovakia',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'BD' => 'Bangladesh',
            'IN' => 'India',
            'CA' => 'Canada',
            'AU' => 'Australia',
            'SG' => 'Singapore',
            'AE' => 'United Arab Emirates',
            'SA' => 'Saudi Arabia',
            'PK' => 'Pakistan',
            'NG' => 'Nigeria',
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            'AG' => 'Antigua and Barbuda',
        ];

        return $countries[$this->country] ?? $this->country;
    }
}
