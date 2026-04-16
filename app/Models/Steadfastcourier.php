<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Steadfastcourier extends Model
{
    protected $fillable = [
        'api_key',
        'secret_key',
        'url',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
