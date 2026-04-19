<?php
// app/Models/Pathaocourier.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pathaocourier extends Model
{
    protected $fillable = [
        'base_url',
        'client_id',
        'client_secret',
        'username',
        'password',
        'grant_type',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'status',
    ];

    protected $casts = [
        'status'           => 'boolean',
        'token_expires_at' => 'datetime',
    ];

    protected $hidden = [
        'client_secret',
        'password',
    ];

    // Token expire হয়েছে কিনা চেক করে
    public function isTokenExpired(): bool
    {
        if (!$this->access_token || !$this->token_expires_at) {
            return true;
        }
        return now()->gte($this->token_expires_at);
    }
}
