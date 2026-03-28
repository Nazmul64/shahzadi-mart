<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';

    protected $fillable = [
        'sub_name',
        'slug',
        'category_id',
        'featured',
        'status',
    ];

    // $sub->name → sub_name কলাম return করে
    public function getNameAttribute(): string
    {
        return $this->sub_name ?? '';
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function childCategories()
    {
        return $this->hasMany(ChildSubCategory::class, 'sub_category_id');
    }
}
