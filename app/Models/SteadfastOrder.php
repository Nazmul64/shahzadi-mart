<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SteadfastOrder extends Model
{
    protected $fillable = [
        'order_id',
        'consignment_id',
        'invoice',
        'tracking_code',
        'cod_amount',
        'status',
        'delivery_charge',
        'tracking_message',
        'response_message',
        'is_sent',
    ];

    protected $casts = [
        'is_sent'         => 'boolean',
        'cod_amount'      => 'float',
        'delivery_charge' => 'float',
    ];

    // ✅ SteadfastOrder → Order relationship
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
