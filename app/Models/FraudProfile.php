<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FraudProfile extends Model
{
    protected $fillable = [
        'phone',
        'ip_address',
        'status',
        'is_blocked',
        'blocked_at',
        'notes',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
        'blocked_at' => 'datetime',
    ];
}
