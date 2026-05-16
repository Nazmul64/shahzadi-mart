<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['vendor_id', 'category', 'amount', 'date', 'description'];

    public function vendor() { return $this->belongsTo(User::class, 'vendor_id'); }
}
