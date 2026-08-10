<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price'           => 'decimal:2',
        'discount_price'  => 'decimal:2',
        'affiliate_price' => 'decimal:2',
        'is_featured'     => 'boolean',
        'is_pre_order'    => 'boolean',   // ← NEW
        'pre_order_date'  => 'date',      // ← NEW
        'quantity'        => 'integer',
        'attributes'      => 'array',
    ];

    // ── Product Types ──────────────────────────────────────────────────────────
    const TYPE_BOOK      = 'book';
    const TYPE_CLOTHING  = 'clothing';
    const TYPE_HAT       = 'hat';
    const TYPE_ACCESSORY = 'accessory';
    const TYPE_OTHER     = 'other';

    public static function productTypes(): array
    {
        return [
            self::TYPE_BOOK      => 'Book',
            self::TYPE_CLOTHING  => 'Clothing',
            self::TYPE_HAT       => 'Hat',
            self::TYPE_ACCESSORY => 'Accessory',
            self::TYPE_OTHER     => 'Other',
        ];
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProductMedia::class)->orderBy('sort_order');
    }

    public function galleryImages(): HasMany
    {
        return $this->hasMany(ProductMedia::class)
            ->where('type', 'image')
            ->orderBy('sort_order');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getSellingPriceAttribute(): float
    {
        return (float) ($this->discount_price ?? $this->price);
    }

    public function getIsAffiliateAttribute(): bool
    {
        return ($this->product_mode ?? 'selling') === 'affiliate';
    }

    public function getHasVariantsAttribute(): bool
    {
        return in_array($this->product_type, [self::TYPE_CLOTHING, self::TYPE_HAT]);
    }

    public function getIsBookAttribute(): bool
    {
        return $this->product_type === self::TYPE_BOOK;
    }

    public function getProductTypeLabelAttribute(): string
    {
        return static::productTypes()[$this->product_type] ?? ucfirst($this->product_type);
    }

    public function getExtraAttribute(string $key, mixed $default = null): mixed
    {
        $attrs = $this->attributes['attributes'] ?? null;
        if (is_string($attrs)) {
            $attrs = json_decode($attrs, true);
        }
        return $attrs[$key] ?? $default;
    }

    // ── NEW: Pre-order label for frontend display ──────────────────────────────

    /**
     * Returns a human-readable pre-order delivery label.
     * e.g. "Pre-order — Ships by 25 Jun 2025"
     */
    public function getPreOrderLabelAttribute(): string
    {
        if (!$this->is_pre_order) {
            return '';
        }

        if ($this->pre_order_note) {
            return $this->pre_order_note;
        }

        if ($this->pre_order_date) {
            return 'Pre-order — Ships by ' . $this->pre_order_date->format('d M Y');
        }

        return 'Available for Pre-order';
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock');
    }

    public function scopeAffiliate($query)
    {
        return $query->where('product_mode', 'affiliate');
    }

    public function scopeSelling($query)
    {
        return $query->where('product_mode', 'selling');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('product_type', $type);
    }

    public function scopeBooks($query)
    {
        return $query->where('product_type', self::TYPE_BOOK);
    }

    // ── NEW ───────────────────────────────────────────────────────────────────

    /** Only pre-order products */
    public function scopePreOrder($query)
    {
        return $query->where('is_pre_order', true);
    }

    public function scopeTopSelling($query, int $limit = 8)
    {
        return $query
            ->with(['categories', 'galleryImages'])
            ->active()
            ->inStock()
            ->limit($limit);
    }
}