<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        // Basic info
        'name',
        'email',
        'password',
        'role',

        // Contact
        'phone',
        'photo',
        'address',

        // Seller info
        'store_name',
        'store_slug',
        'store_description',
        'store_logo',
        'tax_id',

        // Payment
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'mobile_banking_number',

        // Status
        'status',
    ];

    /**
     * The attributes that should be hidden.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
