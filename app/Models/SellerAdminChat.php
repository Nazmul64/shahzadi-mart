<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerAdminChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'sender', // 'admin' or 'seller'
        'message',
        'image',
        'is_read'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
