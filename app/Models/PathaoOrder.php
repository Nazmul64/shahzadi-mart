<?php
// app/Models/PathaoOrder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PathaoOrder extends Model
{
    protected $fillable = [
        'order_id',
        'consignment_id',
        'merchant_order_id',
        'order_status',
        'delivery_fee',
        'store_id',
        'city_id',
        'zone_id',
        'area_id',
        'amount_to_collect',
        'is_sent',
        'response_data',
    ];

    protected $casts = [
        'is_sent' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
