<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_name',
        'amount',
        'status',
    ];

    // ── Scope: শুধু active গুলো
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // ── Helper: status label
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়';
    }

    // ── Helper: status badge color
    public function getStatusColorAttribute(): string
    {
        return $this->status === 'active' ? 'success' : 'danger';
    }
}
