<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPageBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'landing_page_id',
        'type',
        'content',
        'order',
        'status',
    ];

    protected $casts = [
        'content' => 'array',
        'status' => 'boolean',
    ];

    public function landingPage()
    {
        return $this->belongsTo(LandingPage::class);
    }
}
