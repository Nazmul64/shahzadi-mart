<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NagadSetting extends Model
{
    protected $fillable = [
        'status',
        'mode',
        'title',
        'merchant_id',
        'merchant_private_key',
        'nagad_public_key',
        'logo',
    ];
}
