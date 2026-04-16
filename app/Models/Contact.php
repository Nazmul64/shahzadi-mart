<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'contact_number',
        'address',
        'email',
        'google_map_embed_code',
    ];
}
