<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_settings', function (Blueprint $table) {
            $table->id();

            $table->boolean('display_stock_number')->default(true);
            $table->integer('product_whole_sale_max_quantity')->default(5);

            // Home page
            $table->integer('display_flash_deal_products')->default(8);
            $table->integer('display_hot_products')->default(12);
            $table->integer('display_new_products')->default(12);
            $table->integer('display_sale_products')->default(12);
            $table->integer('display_best_seller_products')->default(12);
            $table->integer('display_popular_products')->default(8);
            $table->integer('display_top_rated_products')->default(8);
            $table->integer('display_big_save_products')->default(8);
            $table->integer('display_trending_products')->default(8);

            // Category & Vendor
            $table->integer('category_products_per_page')->default(12);
            $table->integer('vendor_products_per_page')->default(12);

            // Product details
            $table->boolean('display_contact_seller')->default(true);
            $table->integer('display_products_by_seller')->default(8);

            // Vendor product types
            $table->boolean('vendor_physical_products')->default(true);
            $table->boolean('vendor_digital_products')->default(true);
            $table->boolean('vendor_license_products')->default(true);
            $table->boolean('vendor_listing_products')->default(true);
            $table->boolean('vendor_affiliate_products')->default(true);

            // Wishlist
            $table->integer('wishlist_products_per_page')->default(12);
            $table->string('view_wishlist_product_per_page')->default('12,24,36,48,60');

            // Catalog
            $table->decimal('catalog_min_price', 10, 2)->default(0);
            $table->decimal('catalog_max_price', 10, 2)->default(100000);
            $table->integer('catalog_view_product_per_page')->default(12);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_settings');
    }
};
