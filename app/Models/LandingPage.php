<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'product_id',
        'template_name',
        'gtm_id',
        'fb_pixel_id',
        'ga_id',
        'feature_image',
        'video_url',
        'short_description',
        'description',
        'review_text',
        'review_image',
        'bg_color',
        'text_color',
        'btn_color',
        'is_full_width',
        'is_template',
        'preview_image',
        'product_ids',
        'order',
        'status',
    ];

    protected $casts = [
        'product_ids' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFeatureImageUrlAttribute()
    {
        return $this->feature_image ? asset('uploads/landing/' . $this->feature_image) : null;
    }

    public function getReviewImageUrlAttribute()
    {
        return $this->review_image ? asset('uploads/landing/' . $this->review_image) : null;
    }

    public function blocks()
    {
        return $this->hasMany(LandingPageBlock::class)->orderBy('order', 'asc');
    }
}
    