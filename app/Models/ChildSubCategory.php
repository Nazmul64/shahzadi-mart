<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildSubCategory extends Model
{
    use HasFactory;

    protected $table = 'child_sub_categories';

    protected $fillable = [
        'child_sub_name',
        'slug',
        'sub_category_id',
        'featured',
        'status',
    ];

    // $child->name → child_sub_name কলাম return করে
    public function getNameAttribute(): string
    {
        return $this->child_sub_name ?? '';
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}
