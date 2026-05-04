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
        'category_menu_type',
        'site_layout_width',
        'products_per_row',
        'primary_color',
        'header_color',
        'footer_color',
        'header_text_color',
        'footer_text_color',
        'font_family',
        'font_size',
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
                'site_name'          => 'Genius Shop',
                'header_logo'        => null,
                'footer_logo'        => null,
                'invoice_logo'       => null,
                'category_menu_type' => 'fixed',
                'site_layout_width'  => 'boxed',
                'products_per_row'   => 4,
                'primary_color'      => '#be0318',
                'header_color'       => '#ffffff',
                'footer_color'       => '#ffffff',
                'header_text_color'  => '#333333',
                'footer_text_color'  => '#333333',
                'font_family'        => 'Plus Jakarta Sans',
                'font_size'          => 14,
            ]);
        }

        return $setting;
    }
}
