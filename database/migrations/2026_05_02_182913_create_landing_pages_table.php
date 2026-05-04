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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('template_name')->default('landing-1');
            
            // Tracking
            $table->string('gtm_id')->nullable();
            $table->string('fb_pixel_id')->nullable();
            
            // Content
            $table->string('feature_image')->nullable();
            $table->string('video_url')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            
            // Reviews
            $table->text('review_text')->nullable();
            $table->string('review_image')->nullable();
            
            // Customization
            $table->string('bg_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('btn_color')->nullable();
            
            $table->boolean('status')->default(true);
            $table->timestamps();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
