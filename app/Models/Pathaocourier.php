<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pathaocourier extends Model
{
    protected $fillable = [
        'url',
        'token',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
