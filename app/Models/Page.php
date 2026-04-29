<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'description',
        'status',
        'category_id',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    // ── Relationship ──────────────────────────
    public function footercategory()
    {
        return $this->belongsTo(Footercategory::class, 'category_id');
    }

    // Scope for active pages
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Accessor for status label
    public function getStatusLabelAttribute(): string
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }
}
