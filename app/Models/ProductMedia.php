<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMedia extends Model
{
    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ── Scopes ────────────────────────────────────────────────
    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopePdfs($query)
    {
        return $query->where('type', 'pdf');
    }
}
