<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'fax',
        'postal_code',
        'password',
        'image',
        'status',
        'is_vendor',
    ];

    protected $hidden = ['password'];

    /**
     * Check if customer is blocked
     */
    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }

    /**
     * Check if customer is a vendor
     */
    public function isVendor(): bool
    {
        return (bool) $this->is_vendor;
    }
}
