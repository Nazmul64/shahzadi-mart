<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'product_slug',
        'price',
        'original_price',
        'quantity',
        'subtotal',
        'selected_color',
        'selected_size',
    ];

    protected $casts = [
        'price'          => 'float',
        'original_price' => 'float',
        'subtotal'       => 'float',
    ];

    // ── Relationships ──────────────────────────────────────────────
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
