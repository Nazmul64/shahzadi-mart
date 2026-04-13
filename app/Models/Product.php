<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'variants'       => 'array',
        'tags'           => 'array',
        'feature_tags'   => 'array',
        'is_highlighted' => 'boolean',
        'in_catalog'     => 'boolean',
        'is_unlimited'   => 'boolean',
    ];

    // ── Product type options ─────────────────────────────────────────
    public static array $productTypes = [
        'digital'            => 'Digital',
        'physical'           => 'Physical',
        'license'            => 'License',
        'classified_listing' => 'Classified Listing',
        'service'            => 'Service',
    ];

    // ── Relationships ────────────────────────────────────────────────
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

    // ── Accessors ────────────────────────────────────────────────────
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
}
