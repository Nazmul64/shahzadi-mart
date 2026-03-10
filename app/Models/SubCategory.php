<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['sub_name', 'slug', 'category_id','featured', 'status'];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
