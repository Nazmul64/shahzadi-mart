<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            $table->integer('category_img_width')->default(80);
            $table->integer('category_img_height')->default(80);
            $table->string('category_img_shape')->default('circle'); // circle, square
            $table->integer('product_img_height')->default(280);
            $table->string('product_img_fit')->default('cover'); // cover, contain
            $table->integer('category_slider_margin')->default(10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            $table->dropColumn([
                'category_img_width',
                'category_img_height',
                'category_img_shape',
                'product_img_height',
                'product_img_fit',
                'category_slider_margin'
            ]);
        });
    }
};
