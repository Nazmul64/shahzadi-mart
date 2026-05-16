<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'vendor_id', 'name', 'phone', 'photo', 'address', 'nid', 'nid_photo',
        'father_name', 'mother_name', 'father_phone', 'village', 'district', 'thana',
        'starting_salary', 'current_salary', 'joining_date', 'status'
    ];


    public function vendor() { return $this->belongsTo(User::class, 'vendor_id'); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function advances() { return $this->hasMany(SalaryAdvance::class); }
    public function salaries() { return $this->hasMany(Salary::class); }
}
