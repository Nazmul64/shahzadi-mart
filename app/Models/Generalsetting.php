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
        'top_header_bg_color',
        'top_header_text_color',
        'main_header_bg_color',
        'main_header_text_color',
        'button_bg_color',
        'button_text_color',
        'category_slider_status',
        'font_family',
        'font_size',
        'category_img_width',
        'category_img_height',
        'category_img_shape',
        'product_img_height',
        'product_img_fit',
        'category_slider_margin',
        'show_rating_stars',
        'product_img_height_mobile',
        'product_font_size_mobile',
        'marquee_status',
        'marquee_text',
        'payment_discount_status',
        'payment_discount_percentage',
        'facebook_pixel_id',
        'facebook_pixel_status',
        'gtm_id',
        'gtm_status',
        'analytics_id',
        'analytics_status',
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
                'top_header_bg_color' => '#0B1121',
                'top_header_text_color' => '#94a3b8',
                'main_header_bg_color' => '#ffffff',
                'main_header_text_color' => '#333333',
                'button_bg_color' => '#be0318',
                'button_text_color' => '#ffffff',
                'category_slider_status' => 1,
                'font_family'        => 'Plus Jakarta Sans',
                'font_size'          => 14,
                'category_img_width' => 80,
                'category_img_height' => 80,
                'category_img_shape' => 'circle',
                'product_img_height' => 280,
                'product_img_fit'    => 'cover',
                'category_slider_margin' => 10,
                'show_rating_stars' => 1,
                'product_img_height_mobile' => 160,
                'product_font_size_mobile' => 12,
                'marquee_status' => 0,
                'marquee_text' => null,
                'payment_discount_status' => 0,
                'payment_discount_percentage' => 0,
                'analytics_id' => null,
                'analytics_status' => 0,
            ]);
        }

        return $setting;
    }
}
