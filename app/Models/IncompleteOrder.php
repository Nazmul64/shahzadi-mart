<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncompleteOrder extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'address',
        'delivery_area',
        'note',
        'payment_method',
        'subtotal',
        'discount',
        'delivery_fee',
        'total',
        'coupon_code',
        'cart_snapshot',
        'session_id',
        'user_id',
        'page_url',
        'status',
        'last_activity_at',
    ];

    protected $casts = [
        'cart_snapshot'    => 'array',
        'last_activity_at' => 'datetime',
        'subtotal'         => 'float',
        'discount'         => 'float',
        'delivery_fee'     => 'float',
        'total'            => 'float',
    ];

    // ── Scope: incomplete only ────────────────────────────────────
    public function scopeIncomplete($q) { return $q->where('status', 'incomplete'); }

    // ── Mark as recovered (order completed হলে) ───────────────────
    public function markRecovered(): void
    {
        $this->update(['status' => 'recovered']);
    }
     public function steadfastOrder()
    {
        return $this->hasOne(SteadfastOrder::class, 'incomplete_order_id');
    }

    public function pathaoOrder()
    {
        return $this->hasOne(PathaoOrder::class, 'incomplete_order_id');
    }
}
