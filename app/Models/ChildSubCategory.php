<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildSubCategory extends Model
{
    protected $fillable = [
        'child_sub_name',
        'slug',
        'sub_category_id',
        'featured',
        'status',
    ];

    // child_sub_categories.sub_category_id → sub_categories.id
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    // sub_categories.category_id → categories.id (through sub_categories)
    public function category()
    {
        return $this->hasOneThrough(
            Category::class,
            SubCategory::class,
            'id',          // sub_categories.id
            'id',          // categories.id
            'sub_category_id', // child_sub_categories.sub_category_id
            'category_id'  // sub_categories.category_id
        );
    }
}
