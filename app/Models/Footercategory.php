<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footercategory extends Model
{
    protected $fillable = [
        'category_name',
        'category_slug',
    ];

    // একটা category-তে অনেক page থাকবে
    public function pages()
    {
        return $this->hasMany(Page::class, 'category_id');
    }
}
