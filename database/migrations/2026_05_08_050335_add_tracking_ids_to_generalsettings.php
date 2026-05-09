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
            $table->string('facebook_pixel_id')->nullable();
            $table->boolean('facebook_pixel_status')->default(0);
            $table->string('gtm_id')->nullable();
            $table->boolean('gtm_status')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            $table->dropColumn(['facebook_pixel_id', 'facebook_pixel_status', 'gtm_id', 'gtm_status']);
        });
    }
};
