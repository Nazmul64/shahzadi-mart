<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paymentgetewaymanage extends Model
{
    protected $fillable = [
        'gateway_name',
        'username',
        'app_key',
        'app_secret',
        'base_url',
        'password',
        'prefix',
        'success_url',
        'return_url',
        'status',
    ];

    /**
     * Scope to get active gateways only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Get Bkash gateway settings.
     */
    public static function getBkash()
    {
        return static::where('gateway_name', 'bkash')->first();
    }

    /**
     * Get Shurjopay gateway settings.
     */
    public static function getShurjopay()
    {
        return static::where('gateway_name', 'shurjopay')->first();
    }
}
