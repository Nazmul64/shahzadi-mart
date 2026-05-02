<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('footer_settings', function (Blueprint $link) {
            $link->id();
            $link->string('footer_logo')->nullable();
            $link->text('footer_description')->nullable();
            $link->string('facebook_url')->nullable();
            $link->string('instagram_url')->nullable();
            $link->string('twitter_url')->nullable();
            $link->string('youtube_url')->nullable();
            $link->string('tiktok_url')->nullable();
            $link->string('copyright_text')->nullable();
            $link->string('powered_by_text')->nullable();
            $link->string('powered_by_link')->nullable();
            $link->text('payment_methods')->nullable(); // JSON array of enabled methods
            $link->timestamps();
        });

        // Insert a default record
        DB::table('footer_settings')->insert([
            'footer_logo'        => null,
            'footer_description' => 'Your trusted marketplace for premium products. Quality guaranteed, delivered to your door.',
            'copyright_text'     => 'Shahzadi-mart. All rights reserved.',
            'powered_by_text'    => 'Freaku Technologies',
            'powered_by_link'    => '#',
            'payment_methods'    => json_encode(['VISA', 'M-PESA', 'PAYPAL', 'MASTERCARD', 'AIRTEL']),
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
