<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price_override'    => 'decimal:2',
        'discount_override' => 'decimal:2',
        'quantity'          => 'integer',
        'is_active'         => 'boolean',
    ];

    // ── Relations ─────────────────────────────────────────────────────────────

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /** Effective price for this variant */
    public function getSellingPriceAttribute(): float
    {
        $price    = $this->price_override    ?? $this->product->price;
        $discount = $this->discount_override ?? $this->product->discount_price;
        return (float) ($discount ?? $price);
    }

    /** Label: "M / Red" or "L" or "Red" */
    public function getLabelAttribute(): string
    {
        return collect([$this->size, $this->color])->filter()->implode(' / ');
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock');
    }

    public function scopeBySize($query, string $size)
    {
        return $query->where('size', $size);
    }

    public function scopeByColor($query, string $color)
    {
        return $query->where('color', $color);
    }
}
