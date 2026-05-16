<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSellerChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'session_uuid',
        'seller_id',
        'product_id',
        'sender_type',
        'message',
        'attachment',
        'is_read',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
