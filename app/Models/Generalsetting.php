<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generalsetting extends Model
{
    protected $fillable = [
        'header_logo',
        'footer_logo',
        'invoice_logo',
        'site_name',
    ];

    /**
     * Always return the single settings row.
     * Uses updateOrCreate so id=1 is always guaranteed to exist.
     */
    public static function getSettings(): self
    {
        $setting = self::first();

        if (!$setting) {
            $setting = self::create([
                'site_name'    => 'Genius Shop',
                'header_logo'  => null,
                'footer_logo'  => null,
                'invoice_logo' => null,
            ]);
        }

        return $setting;
    }
}
