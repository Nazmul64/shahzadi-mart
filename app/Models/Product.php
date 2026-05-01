<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'sku', 'vendor',
        'category_id', 'sub_category_id', 'child_sub_category_id',
        // Multiple IDs stored as JSON arrays
        'brand_ids', 'color_ids', 'unit_ids', 'size_ids',
        'product_type', 'upload_type', 'product_file', 'product_url',
        'description', 'return_policy',
        'feature_image', 'gallery_images',
        'current_price', 'discount_price', 'stock', 'is_unlimited',
        'youtube_url', 'tags', 'feature_tags',
        'status', 'is_highlighted', 'in_catalog',
        'meta_tags', 'meta_description',
        'is_bestseller', 'bestseller_at',
        'is_flash_sale', 'flash_sale_price', 'flash_sale_starts_at', 'flash_sale_ends_at',
        'is_new_arrival', 'arrived_at',
    ];

    protected $casts = [
        'gallery_images'       => 'array',
        'tags'                 => 'array',
        'feature_tags'         => 'array',
        // Multiple IDs - stored as JSON, cast to array
        'brand_ids'            => 'array',
        'color_ids'            => 'array',
        'unit_ids'             => 'array',
        'size_ids'             => 'array',
        'is_highlighted'       => 'boolean',
        'in_catalog'           => 'boolean',
        'is_unlimited'         => 'boolean',
        'is_flash_sale'        => 'boolean',
        'flash_sale_starts_at' => 'datetime',
        'flash_sale_ends_at'   => 'datetime',
        'is_new_arrival'       => 'boolean',
        'arrived_at'           => 'datetime',
        'is_bestseller'        => 'boolean',
        'bestseller_at'        => 'datetime',
    ];

    public static array $productTypes = [
        'digital'            => 'Digital',
        'physical'           => 'Physical',
        'license'            => 'License',
        'classified_listing' => 'Classified Listing',
        'service'            => 'Service',
    ];

    // ── Relationships ─────────────────────────────────────────────────
    public function category()         { return $this->belongsTo(Category::class, 'category_id'); }
    public function subCategory()      { return $this->belongsTo(SubCategory::class, 'sub_category_id'); }
    public function childSubCategory() { return $this->belongsTo(ChildSubCategory::class, 'child_sub_category_id'); }

    /**
     * Multiple brands via JSON IDs
     * Usage: $product->brands  → Collection of Brand models
     */
    public function brands()
    {
        $ids = $this->brand_ids ?? [];
        return Brand::whereIn('id', $ids)->orderBy('name')->get();
    }

    /**
     * Multiple colors via JSON IDs
     * Usage: $product->colors  → Collection of Color models
     */
    public function colors()
    {
        $ids = $this->color_ids ?? [];
        return Color::whereIn('id', $ids)->orderBy('name')->get();
    }

    /**
     * Multiple units via JSON IDs
     * Usage: $product->units  → Collection of Unit models
     */
    public function units()
    {
        $ids = $this->unit_ids ?? [];
        return Unit::whereIn('id', $ids)->orderBy('name')->get();
    }

    /**
     * Multiple sizes via JSON IDs
     * Usage: $product->sizes  → Collection of Size models
     */
    public function sizes()
    {
        $ids = $this->size_ids ?? [];
        return Size::whereIn('id', $ids)->orderBy('name')->get();
    }

    // ── Convenience single accessors (first item) ─────────────────────
    public function getFirstBrandAttribute()
    {
        $ids = $this->brand_ids ?? [];
        return count($ids) ? Brand::find($ids[0]) : null;
    }

    public function getFirstColorAttribute()
    {
        $ids = $this->color_ids ?? [];
        return count($ids) ? Color::find($ids[0]) : null;
    }

    public function getFirstUnitAttribute()
    {
        $ids = $this->unit_ids ?? [];
        return count($ids) ? Unit::find($ids[0]) : null;
    }

    public function getFirstSizeAttribute()
    {
        $ids = $this->size_ids ?? [];
        return count($ids) ? Size::find($ids[0]) : null;
    }

    public function orderItems() { return $this->hasMany(OrderItem::class, 'product_id'); }

    // ── Scopes ────────────────────────────────────────────────────────
    public function scopeFlashSales($query)
    {
        $now = Carbon::now();
        return $query->where('is_flash_sale', true)->where('status', 'active')
            ->where(fn($q) => $q->whereNull('flash_sale_starts_at')->orWhere('flash_sale_starts_at', '<=', $now))
            ->where(fn($q) => $q->whereNull('flash_sale_ends_at')->orWhere('flash_sale_ends_at', '>=', $now));
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true)->where('status', 'active');
    }

    // ── Accessors ─────────────────────────────────────────────────────
    public function getIsFlashSaleActiveAttribute(): bool
    {
        if (!$this->is_flash_sale) return false;
        $now = Carbon::now();
        if ($this->flash_sale_starts_at && $now->lt($this->flash_sale_starts_at)) return false;
        if ($this->flash_sale_ends_at   && $now->gt($this->flash_sale_ends_at))   return false;
        return true;
    }

    public function getEffectivePriceAttribute(): float
    {
        if ($this->is_flash_sale_active && $this->flash_sale_price !== null) return (float) $this->flash_sale_price;
        if ($this->discount_price !== null) return (float) $this->discount_price;
        return (float) $this->current_price;
    }

    public function getImageAttribute(): string      { return $this->feature_image ?? ''; }
    public function getProductNameAttribute(): string { return $this->name; }
}
