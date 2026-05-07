<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DigitalProduct extends Model
{
    protected $fillable = [
        'name', 'slug', 'sku', 'short_description',
        'category_id', 'sub_category_id', 'child_sub_category_id', 'brand_id',
        'description', 'feature_image', 'additional_thumbnail', 'gallery_images',
        'current_price', 'buying_price', 'discount_price', 'stock_quantity',
        'upload_type', 'product_file', 'product_url', 'license_keys',
        'video_type', 'video_url', 'status', 'is_pinned',
        'meta_tags', 'meta_title', 'meta_description', 'meta_keywords'
    ];

    protected $casts = [
        'gallery_images'        => 'array',
        'additional_thumbnail'  => 'array',
        'license_keys'          => 'array',
        'is_pinned'             => 'boolean',
        'buying_price'          => 'decimal:2',
        'current_price'         => 'decimal:2',
        'discount_price'        => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────────────────
    public function category()         { return $this->belongsTo(Category::class, 'category_id'); }
    public function subCategory()      { return $this->belongsTo(SubCategory::class, 'sub_category_id'); }
    public function childSubCategory() { return $this->belongsTo(ChildSubCategory::class, 'child_sub_category_id'); }

    public function reviews()
    {
        // For simplicity, reusing Producreview table if needed, 
        // but might need a separate table if they are strictly separated.
        // For now, let's keep it simple.
        return $this->hasMany(Producreview::class, 'digital_product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'digital_product_id');
    }
}
