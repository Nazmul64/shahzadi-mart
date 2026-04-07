<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    protected $fillable = [
        'code',
        'allow_product_type',
        'category_id',
        'sub_category_id',
        'child_sub_category_id',
        'type',
        'percentage',
        'amount',
        'quantity',
        'quantity_limit',
        'used',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function getAmountDisplayAttribute(): string
    {
        if ($this->type === 'discount_by_percentage') {
            return $this->percentage . '%';
        }
        return number_format($this->amount, 2) . '$';
    }

    public function getTypeDisplayAttribute(): string
    {
        return match ($this->type) {
            'discount_by_percentage' => 'Discount By Percentage',
            'discount_by_amount'     => 'Discount By Amount',
            default                  => $this->type,
        };
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function childSubCategory()
    {
        return $this->belongsTo(ChildSubCategory::class, 'child_sub_category_id');
    }
}
