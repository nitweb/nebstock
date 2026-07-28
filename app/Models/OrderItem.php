<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price'    => 'decimal:2',
        'quantity' => 'integer',
    ];

    // ── Relations ─────────────────────────────────────────────────────────────
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    // unit_price = price (alias for blade compatibility)
    public function getUnitPriceAttribute(): float
    {
        return (float) $this->price;
    }

    // subtotal = price * quantity (calculated, not stored in DB)
    public function getSubtotalAttribute(): float
    {
        return (float) ($this->price * $this->quantity);
    }

    // product_name from relation (not stored in DB)
    public function getProductNameAttribute(): string
    {
        return $this->product?->name ?? '—';
    }
}
