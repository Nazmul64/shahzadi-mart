<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactinfomationadmin extends Model
{
    protected $fillable = [
        'watsapp_url',
        'messanger_url',
        'phone',
    ];
}
