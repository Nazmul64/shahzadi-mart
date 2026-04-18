<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigncreate extends Model
{
    protected $fillable = [
        'title', 'product_id', 'media_type',
        'image', 'image_two', 'image_three',
        'video', 'video_url',
        'review', 'review_image',
        'short_description', 'description', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset($this->image) : null;
    }

    public function getImageTwoUrlAttribute(): ?string
    {
        return $this->image_two ? asset($this->image_two) : null;
    }

    public function getImageThreeUrlAttribute(): ?string
    {
        return $this->image_three ? asset($this->image_three) : null;
    }

    public function getReviewImageUrlAttribute(): ?string
    {
        return $this->review_image ? asset($this->review_image) : null;
    }

    public function getVideoUrlAttribute(): ?string
    {
        return $this->video ? asset($this->video) : null;
    }
}
