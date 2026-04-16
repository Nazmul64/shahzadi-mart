<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagmanager extends Model
{
    protected $fillable = [
        'google_tag_id',
        'status',
    ];
}
