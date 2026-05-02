<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'footer_logo',
        'footer_description',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'youtube_url',
        'tiktok_url',
        'copyright_text',
        'powered_by_text',
        'powered_by_link',
        'payment_methods',
    ];

    protected $casts = [
        'payment_methods' => 'array',
    ];

    /**
     * Always return the single settings row.
     */
    public static function getSettings(): self
    {
        return self::first() ?: self::create([
            'footer_description' => 'Your trusted marketplace for premium products. Quality guaranteed, delivered to your door.',
            'copyright_text'     => 'Shahzadi-mart. All rights reserved.',
            'powered_by_text'    => 'Freaku Technologies',
            'powered_by_link'    => '#',
            'payment_methods'    => ['VISA', 'M-PESA', 'PAYPAL', 'MASTERCARD', 'AIRTEL'],
        ]);
    }
}
