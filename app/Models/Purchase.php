<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id',
        'purchase_number',
        'title',
        'purchase_date',
        'total_amount',
        'notes',
        'lot_slip_image',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public static function generatePurchaseNumber()
    {
        $last = self::latest()->first();
        $number = $last ? (int) substr($last->purchase_number, 4) + 1 : 1;
        return 'PUR-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
