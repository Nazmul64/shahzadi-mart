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
        'tracking_link',
        'cod_amount',
        'status',
        'delivery_charge',
        'tracking_message',
        'response_message',  // longText — JSON store হবে
        'is_sent',
    ];

    protected $casts = [
        'is_sent'          => 'boolean',
        'cod_amount'       => 'float',
        'delivery_charge'  => 'float',
    ];

    // SteadfastOrder → Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // response_message থেকে parsed array পাও
    public function getResponseDataAttribute(): array
    {
        if (empty($this->response_message)) return [];
        $decoded = json_decode($this->response_message, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Steadfast status থেকে বাংলা label
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'in_review'                          => '🔍 রিভিউতে আছে',
            'pending'                            => '⏳ অপেক্ষমান',
            'delivered'                          => '✅ ডেলিভারি হয়েছে',
            'partial_delivered'                  => '⚠️ আংশিক ডেলিভারি',
            'delivered_approval_pending'         => '🕐 ডেলিভারি অনুমোদন বাকি',
            'partial_delivered_approval_pending' => '🕐 আংশিক ডেলিভারি অনুমোদন বাকি',
            'cancelled'                          => '❌ বাতিল',
            'cancelled_approval_pending'         => '🕐 বাতিল অনুমোদন বাকি',
            'hold'                               => '⏸️ হোল্ড',
            'unknown'                            => '❓ অজানা',
            default                              => ucfirst($this->status),
        };
    }
}
