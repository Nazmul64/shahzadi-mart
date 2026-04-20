<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutForCompany extends Model
{
    protected $table = 'about_for_companies';

    protected $fillable = [
        'company_name',
        'tagline',
        'short_description',
        'about_description',
        'mission',
        'vision',
        'values',
        'logo',
        'banner_image',
        'about_image',
        'founded_year',
        'total_employees',
        'total_clients',
        'total_projects',
        'email',
        'phone',
        'address',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'linkedin',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Image URL helpers ─────────────────────────────────────────────

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset($this->logo) : null;
    }

    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner_image ? asset($this->banner_image) : null;
    }

    public function getAboutImageUrlAttribute(): ?string
    {
        return $this->about_image ? asset($this->about_image) : null;
    }
}
