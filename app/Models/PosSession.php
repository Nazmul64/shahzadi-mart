<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosSession extends Model
{
    protected $fillable = [
        'invoice_no',
        'customer_id',
        'created_by',
        'sub_total',
        'discount_amount',
        'tax_amount',
        'shipping_amount',
        'grand_total',
        'coupon_code',
        'coupon_discount',
        'status',
        'payment_method',
        'note',
    ];

    protected $casts = [
        'sub_total'       => 'float',
        'discount_amount' => 'float',
        'tax_amount'      => 'float',
        'shipping_amount' => 'float',
        'grand_total'     => 'float',
        'coupon_discount' => 'float',
    ];

    // ── Relationships ─────────────────────────────────────────

    public function items()
    {
        return $this->hasMany(PosSessionItem::class, 'pos_session_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'created_by');
    }

    // ── Invoice number generator ──────────────────────────────

    public static function generateInvoiceNo(): string
    {
        $last = static::latest('id')->first();
        $next = $last
            ? ((int) ltrim(str_replace('POS-', '', $last->invoice_no), '0') + 1)
            : 1;
        return 'POS-' . str_pad($next, 6, '0', STR_PAD_LEFT);
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // ── Accessors ─────────────────────────────────────────────

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'completed'  => '<span class="badge bg-success">Completed</span>',
            'draft'      => '<span class="badge bg-warning text-dark">Draft</span>',
            'cancelled'  => '<span class="badge bg-danger">Cancelled</span>',
            default      => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
