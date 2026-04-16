<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'sku', 'vendor',
        'category_id', 'sub_category_id', 'child_sub_category_id',
        'product_type', 'upload_type', 'product_file', 'product_url',
        'description', 'return_policy',
        'feature_image', 'gallery_images', 'variants',
        'current_price', 'discount_price', 'stock', 'is_unlimited',
        'youtube_url', 'tags', 'feature_tags',
        'status', 'is_highlighted', 'in_catalog',
        'meta_tags', 'meta_description',
        'is_bestseller',

        // ── Flash Sale ────────────────────────────────────────────
        'is_flash_sale', 'flash_sale_price', 'flash_sale_starts_at', 'flash_sale_ends_at',

        // ── New Arrivals ──────────────────────────────────────────
        'is_new_arrival', 'arrived_at',
    ];

    protected $casts = [
        'gallery_images'       => 'array',
        'variants'             => 'array',
        'tags'                 => 'array',
        'feature_tags'         => 'array',
        'is_highlighted'       => 'boolean',
        'in_catalog'           => 'boolean',
        'is_unlimited'         => 'boolean',

        // ── Flash Sale ────────────────────────────────────────────
        'is_flash_sale'        => 'boolean',
        'flash_sale_starts_at' => 'datetime',
        'flash_sale_ends_at'   => 'datetime',

        // ── New Arrivals ──────────────────────────────────────────
        'is_new_arrival'       => 'boolean',
        'arrived_at'           => 'datetime',
    ];

    // ── Product type options ──────────────────────────────────────────
    public static array $productTypes = [
        'digital'            => 'Digital',
        'physical'           => 'Physical',
        'license'            => 'License',
        'classified_listing' => 'Classified Listing',
        'service'            => 'Service',
    ];

    // ── Relationships ─────────────────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function childSubCategory()
    {
        return $this->belongsTo(ChildSubCategory::class, 'child_sub_category_id');
    }

    // ── Scopes ────────────────────────────────────────────────────────

    /** Active flash sales running right now */
    public function scopeFlashSales($query)
    {
        $now = Carbon::now();
        return $query->where('is_flash_sale', true)
                     ->where('status', 'active')
                     ->where(function ($q) use ($now) {
                         $q->whereNull('flash_sale_starts_at')
                           ->orWhere('flash_sale_starts_at', '<=', $now);
                     })
                     ->where(function ($q) use ($now) {
                         $q->whereNull('flash_sale_ends_at')
                           ->orWhere('flash_sale_ends_at', '>=', $now);
                     });
    }

    /** Products marked as new arrivals */
    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true)
                     ->where('status', 'active');
    }

    // ── Accessors ─────────────────────────────────────────────────────
    public function getStockLabelAttribute(): string
    {
        if ($this->is_unlimited || $this->stock === null) return 'Unlimited';
        return (string) $this->stock;
    }

    public function getProductTypeLabelAttribute(): string
    {
        return static::$productTypes[$this->product_type] ?? ucfirst($this->product_type);
    }

    public function getIsOutOfStockAttribute(): bool
    {
        if ($this->is_unlimited) return false;
        return ($this->stock ?? 0) === 0;
    }

    public function getIsLowStockAttribute(): bool
    {
        if ($this->is_unlimited) return false;
        $s = $this->stock ?? 0;
        return $s > 0 && $s <= 10;
    }

    /**
     * Returns true if this product's flash sale is currently active
     * (is_flash_sale=true AND now is within the start/end window).
     */
    public function getIsFlashSaleActiveAttribute(): bool
    {
        if (! $this->is_flash_sale) return false;
        $now = Carbon::now();
        if ($this->flash_sale_starts_at && $now->lt($this->flash_sale_starts_at)) return false;
        if ($this->flash_sale_ends_at   && $now->gt($this->flash_sale_ends_at))   return false;
        return true;
    }

    /**
     * The effective selling price:
     * flash sale price > discount price > current price
     */
    public function getEffectivePriceAttribute(): float
    {
        if ($this->is_flash_sale_active && $this->flash_sale_price !== null) {
            return (float) $this->flash_sale_price;
        }
        if ($this->discount_price !== null) {
            return (float) $this->discount_price;
        }
        return (float) $this->current_price;
    }

    /**
     * Seconds remaining until the flash sale ends (null if no active sale or no end time).
     */
    public function getFlashSaleSecondsRemainingAttribute(): ?int
    {
        if (! $this->is_flash_sale_active) return null;
        if (! $this->flash_sale_ends_at)   return null;
        $diff = Carbon::now()->diffInSeconds($this->flash_sale_ends_at, false);
        return $diff > 0 ? $diff : 0;
    }
    public function getProductNameAttribute(): string
{
    return $this->name;
}

/**
 * Alias: blade uses $product->image
 */
public function getImageAttribute(): string
{
    return $this->feature_image ?? '';
}


    // THIS was missing — fixes the BadMethodCallException
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
