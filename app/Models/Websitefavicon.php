<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Websitefavicon extends Model
{
    protected $fillable = ['favicon_logo'];

    public static function getSettings(): static
    {
        return static::firstOrCreate([]);
    }
}
