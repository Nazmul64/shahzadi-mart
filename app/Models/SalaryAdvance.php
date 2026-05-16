<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryAdvance extends Model
{
    protected $fillable = ['employee_id', 'amount', 'date', 'month', 'note'];

    public function employee() { return $this->belongsTo(Employee::class); }
}
