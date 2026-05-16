<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'employee_id', 'month', 'base_salary', 'present_days', 
        'absent_days', 'advances', 'deductions', 'bonuses', 
        'net_payable', 'is_paid', 'payment_date'
    ];

    public function employee() { return $this->belongsTo(Employee::class); }
}
