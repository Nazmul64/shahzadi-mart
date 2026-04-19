<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producreview extends Model
{
    protected $table = 'producreviews';

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'review',
        'is_approved',
    ];

    protected $casts = [
        'rating'      => 'integer',
        'is_approved' => 'boolean',
    ];

    // ── Relationships ────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ── Scopes ───────────────────────────────────────────────────

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // ── Helpers ──────────────────────────────────────────────────

    public function getStarsAttribute(): string
    {
        $filled = str_repeat('★', $this->rating);
        $empty  = str_repeat('☆', 5 - $this->rating);
        return $filled . $empty;
    }
}
