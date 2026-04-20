<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PathaoOrder extends Model
{
    protected $fillable = [
        'order_id',
        'incomplete_order_id',
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
        'is_sent'           => 'boolean',
        'delivery_fee'      => 'float',
        'amount_to_collect' => 'float',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function incompleteOrder(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(IncompleteOrder::class);
    }

    // ─── Accessors ────────────────────────────────────────────────

    /**
     * response_data (JSON string) থেকে parsed array পাও
     */
    public function getParsedResponseAttribute(): array
    {
        if (empty($this->response_data)) {
            return [];
        }

        $decoded = json_decode($this->response_data, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Pathao order status থেকে বাংলা label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->order_status) {
            'Pending'           => '⏳ অপেক্ষমান',
            'Pickup_Requested'  => '📦 পিকআপ রিকোয়েস্ট করা হয়েছে',
            'Picked_Up'         => '🚚 পিকআপ হয়েছে',
            'In_Transit'        => '🛣️ ট্রানজিটে আছে',
            'Delivered'         => '✅ ডেলিভারি হয়েছে',
            'Partially_Delivered' => '⚠️ আংশিক ডেলিভারি',
            'Returned'          => '↩️ ফেরত এসেছে',
            'Cancelled'         => '❌ বাতিল',
            'Hold'              => '⏸️ হোল্ড',
            default             => ucfirst($this->order_status ?? 'Unknown'),
        };
    }
}
