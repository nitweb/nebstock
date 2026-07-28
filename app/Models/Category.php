<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Category extends Model
{
    protected $guarded = [];

    protected $casts = [
        'applicable_types' => 'array',
    ];

    // ── Relations ─────────────────────────────────────────────────────────────

    /** Parent category (self-referential) */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /** Immediate children */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('sort_order');
    }

    /**
     * Recursive children — loads ALL descendants in one eager-load chain.
     * Usage: Category::with('allChildren.allChildren')->get()
     * Or use the helper: Category::root()->with('recursiveChildren')->get()
     */
    public function recursiveChildren(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('sort_order')
            ->with('recursiveChildren');   // <-- recursive eager loading
    }

    /** Products in this category */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Collect all descendant category IDs (self + all children, grandchildren…).
     * Useful for filtering products: "show all products in Clothing and its sub-cats"
     *
     * $category->allDescendantIds()  →  [3, 7, 8, 12, 15]
     */
    public function allDescendantIds(): array
    {
        $ids = [$this->id];
        foreach ($this->recursiveChildren as $child) {
            $ids = array_merge($ids, $child->allDescendantIds());
        }
        return $ids;
    }

    /**
     * Full breadcrumb from root to this category.
     * Returns a Collection of Category models: [Root, Parent, Self]
     */
    public function breadcrumb(): Collection
    {
        $crumbs = collect([$this]);
        $node   = $this;
        while ($node->parent_id && $node->parent) {
            $crumbs->prepend($node->parent);
            $node = $node->parent;
        }
        return $crumbs;
    }

    /** Depth level (0 = root, 1 = child, 2 = grandchild …) */
    public function getDepthAttribute(): int
    {
        $depth = 0;
        $node  = $this;
        while ($node->parent_id) {
            $depth++;
            $node = $node->parent()->first();
            if (!$node) break;
        }
        return $depth;
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /** Only top-level categories (no parent) */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /** Categories that support a given product type */
    public function scopeForType($query, string $type)
    {
        return $query->where(function ($q) use ($type) {
            $q->whereNull('applicable_types')
                ->orWhereJsonContains('applicable_types', $type);
        });
    }
}
