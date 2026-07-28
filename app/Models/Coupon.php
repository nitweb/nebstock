<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Coupon valid কিনা চেক করে
    public function isValid(float $cartTotal): array
    {
        if ($this->status !== 'active') {
            return ['valid' => false, 'message' => 'This coupon is inactive.'];
        }

        $today = Carbon::today();

        if ($this->start_date && $today->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'This coupon is not active yet.'];
        }

        if ($this->end_date && $today->gt($this->end_date)) {
            return ['valid' => false, 'message' => 'This coupon has expired.'];
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'This coupon usage limit has been reached.'];
        }

        if ($cartTotal < $this->minimum_amount) {
            return [
                'valid' => false,
                'message' => 'Minimum order amount of $' . number_format($this->minimum_amount, 2) . ' required.',
            ];
        }

        return ['valid' => true, 'message' => 'Coupon applied!'];
    }

    // Discount amount হিসাব করে
    public function calculateDiscount(float $cartTotal): float
    {
        if ($this->coupon_type === 'percent') {
            return round($cartTotal * ($this->coupon_value / 100), 2);
        }

        return min((float) $this->coupon_value, $cartTotal);
    }
}
