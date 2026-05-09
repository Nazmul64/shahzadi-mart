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
            $table->boolean('marquee_status')->default(0);
            $table->text('marquee_text')->nullable();
            $table->boolean('payment_discount_status')->default(0);
            $table->decimal('payment_discount_percentage', 5, 2)->default(0.00);
            $table->string('analytics_id')->nullable();
            $table->boolean('analytics_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            $table->dropColumn([
                'marquee_status',
                'marquee_text',
                'payment_discount_status',
                'payment_discount_percentage',
                'analytics_id',
                'analytics_status'
            ]);
        });
    }
};
