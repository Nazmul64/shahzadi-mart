<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'phone',
        'address',
        'delivery_area',
        'note',
        'payment_method',
        'payment_status',
        'transaction_id',
        'order_status',
        'subtotal',
        'discount',
        'delivery_fee',
        'total',
        'coupon_code',
    ];

    // ── Status Labels ──────────────────────────────────────────────
    public static array $orderStatuses = [
        'pending'    => 'Pending',
        'processing' => 'Processing',
        'shipped'    => 'Shipped',
        'delivered'  => 'Delivered',
        'cancelled'  => 'Cancelled',
    ];

    public static array $paymentStatuses = [
        'pending' => 'Pending',
        'paid'    => 'Paid',
        'failed'  => 'Failed',
    ];

    public static array $paymentMethods = [
        'cod'        => 'Cash On Delivery',
        'bkash'      => 'bKash',
        'shurjopay'  => 'ShurjoPay',
        'uddoktapay' => 'UddoktaPay',
        'aamarpay'   => 'aamarPay',
    ];

    // ── Relationships ──────────────────────────────────────────────
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // ── Accessors ──────────────────────────────────────────────────
    public function getOrderStatusLabelAttribute(): string
    {
        return static::$orderStatuses[$this->order_status] ?? ucfirst($this->order_status);
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return static::$paymentStatuses[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return static::$paymentMethods[$this->payment_method] ?? ucfirst($this->payment_method);
    }

    // ── Helpers ────────────────────────────────────────────────────
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (static::where('order_number', $number)->exists());

        return $number;
    }
}
