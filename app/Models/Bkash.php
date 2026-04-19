<?php
// ══════════════════════════════════════════════════
// app/Models/Bkash.php
// ══════════════════════════════════════════════════

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bkash extends Model
{
    protected $table = 'bkashes';

    protected $fillable = [
        'username',
        'app_key',
        'app_secret',
        'base_url',
        'password',
        'status',
    ];
}
