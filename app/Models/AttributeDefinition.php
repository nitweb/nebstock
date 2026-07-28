<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeDefinition extends Model
{
    protected $guarded = [];

    protected $casts = [
        'applicable_types' => 'array',
    ];

    // ── Scopes ────────────────────────────────────────────────────────────────

    /** Attributes that apply to a specific product type */
    public function scopeForType($query, string $type)
    {
        return $query->where(function ($q) use ($type) {
            $q->whereNull('applicable_types')
                ->orWhereJsonContains('applicable_types', $type);
        })->orderBy('sort_order');
    }
}
