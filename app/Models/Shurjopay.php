<?php
// ══════════════════════════════════════════════════
// app/Models/Shurjopay.php
// ══════════════════════════════════════════════════

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shurjopay extends Model
{
    protected $table = 'shurjopays';

    protected $fillable = [
        'username',
        'prefix',
        'success_url',
        'return_url',
        'base_url',
        'password',
        'status',
    ];
}
