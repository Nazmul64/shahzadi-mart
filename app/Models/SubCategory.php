<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'sub_name',
        'slug',
        'category_id',
        'featured',
        'status',
    ];

    // sub_categories.category_id → categories.id
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // sub_categories.id → child_sub_categories.sub_category_id
    public function childSubCategories()
    {
        return $this->hasMany(ChildSubCategory::class, 'sub_category_id');
    }
}
