<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Font extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function getFontFileUrlAttribute(): ?string
    {
        return $this->font_file ? url('upload/fonts/' . $this->font_file) : null;
    }

    public function getPreviewImageUrlAttribute(): string
    {
        return $this->preview_image
            ? url('upload/fonts/preview/' . $this->preview_image)
            : url('upload/no_image.jpg');
    }
}
