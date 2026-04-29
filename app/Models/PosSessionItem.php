<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosSessionItem extends Model
{
    protected $fillable = [
        'pos_session_id',
        'product_id',
        'variant_label',
        'unit_price',
        'quantity',
        'total_price',
    ];

    protected $casts = [
        'unit_price'  => 'float',
        'total_price' => 'float',
        'quantity'    => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────

    public function posSession()
    {
        return $this->belongsTo(PosSession::class, 'pos_session_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
