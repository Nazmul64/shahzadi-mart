<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'category_photo',
        'slug',
        'featured',
        'status',
        'new_category_photo',
    ];

    // $category->name → category_name কলাম return করে
    public function getNameAttribute(): string
    {
        return $this->category_name ?? '';
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
