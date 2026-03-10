<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productsetting extends Model
{
    protected $table = 'product_settings';

    protected $fillable = [
        'display_stock_number',
        'product_whole_sale_max_quantity',

        'display_flash_deal_products',
        'display_hot_products',
        'display_new_products',
        'display_sale_products',
        'display_best_seller_products',
        'display_popular_products',
        'display_top_rated_products',
        'display_big_save_products',
        'display_trending_products',

        'category_products_per_page',
        'vendor_products_per_page',

        'display_contact_seller',
        'display_products_by_seller',

        'vendor_physical_products',
        'vendor_digital_products',
        'vendor_license_products',
        'vendor_listing_products',
        'vendor_affiliate_products',

        'wishlist_products_per_page',
        'view_wishlist_product_per_page',

        'catalog_min_price',
        'catalog_max_price',
        'catalog_view_product_per_page',
    ];

    protected $casts = [
        'display_stock_number'      => 'boolean',
        'display_contact_seller'    => 'boolean',
        'vendor_physical_products'  => 'boolean',
        'vendor_digital_products'   => 'boolean',
        'vendor_license_products'   => 'boolean',
        'vendor_listing_products'   => 'boolean',
        'vendor_affiliate_products' => 'boolean',
    ];

    public static function instance(): static
    {
        return static::firstOrCreate([], [
            'display_stock_number' => true,
            'product_whole_sale_max_quantity' => 5,
            'display_flash_deal_products' => 8,
            'display_hot_products' => 12,
            'display_new_products' => 12,
            'display_sale_products' => 12,
            'display_best_seller_products' => 12,
            'display_popular_products' => 8,
            'display_top_rated_products' => 8,
            'display_big_save_products' => 8,
            'display_trending_products' => 8,
            'category_products_per_page' => 12,
            'vendor_products_per_page' => 12,
            'display_contact_seller' => true,
            'display_products_by_seller' => 8,
            'vendor_physical_products' => true,
            'vendor_digital_products' => true,
            'vendor_license_products' => true,
            'vendor_listing_products' => true,
            'vendor_affiliate_products' => true,
            'wishlist_products_per_page' => 12,
            'view_wishlist_product_per_page' => '12,24,36,48,60',
            'catalog_min_price' => 0,
            'catalog_max_price' => 100000,
            'catalog_view_product_per_page' => 12,
        ]);
    }
}
