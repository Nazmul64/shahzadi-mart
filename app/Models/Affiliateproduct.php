<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateProduct extends Model
{
    use HasFactory;

    protected $table = 'affiliate_products';

    protected $fillable = [
        'product_name',
        'product_sku',
        'product_affiliate_link',
        'category_id',
        'sub_category_id',
        'child_category_id',
        'product_stock',
        'allow_measurement',
        'product_measurement',
        'allow_condition',
        'product_condition',
        'allow_shipping_time',
        'estimated_shipping_time',
        'allow_colors',
        'product_colors',
        'allow_sizes',
        'product_sizes',
        'product_description',
        'buy_return_policy',
        'feature_image_source',
        'feature_image',
        'gallery_images',
        'current_price',
        'discount_price',
        'youtube_video_url',
        'feature_tags',
        'tags',
        'allow_seo',
        'meta_tags',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'gallery_images'      => 'array',
        'feature_tags'        => 'array',
        'allow_measurement'   => 'boolean',
        'allow_condition'     => 'boolean',
        'allow_shipping_time' => 'boolean',
        'allow_colors'        => 'boolean',
        'allow_sizes'         => 'boolean',
        'allow_seo'           => 'boolean',
        'current_price'       => 'decimal:2',
        'discount_price'      => 'decimal:2',
    ];

    // ── Relationships ──────────────────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function childCategory()
    {
        return $this->belongsTo(ChildSubCategory::class, 'child_category_id');
    }

    // ── Accessors ──────────────────────────────────────────────────────
    public function getFeatureImageUrlAttribute(): string
    {
        if (!$this->feature_image) {
            return asset('admin/img/no-image.png');
        }
        // URL source হলে সরাসরি return
        if (str_starts_with($this->feature_image, 'http')) {
            return $this->feature_image;
        }
        return asset('storage/' . $this->feature_image);
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (!$this->gallery_images) return [];
        return array_map(fn($path) => asset('storage/' . $path), $this->gallery_images);
    }
}
