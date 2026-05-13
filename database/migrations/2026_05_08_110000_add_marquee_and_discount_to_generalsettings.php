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
            if (!Schema::hasColumn('generalsettings', 'marquee_status')) {
                $table->boolean('marquee_status')->default(0);
            }
            if (!Schema::hasColumn('generalsettings', 'marquee_text')) {
                $table->text('marquee_text')->nullable();
            }
            if (!Schema::hasColumn('generalsettings', 'payment_discount_status')) {
                $table->boolean('payment_discount_status')->default(0);
            }
            if (!Schema::hasColumn('generalsettings', 'payment_discount_percentage')) {
                $table->decimal('payment_discount_percentage', 5, 2)->default(0.00);
            }
            if (!Schema::hasColumn('generalsettings', 'analytics_id')) {
                $table->string('analytics_id')->nullable();
            }
            if (!Schema::hasColumn('generalsettings', 'analytics_status')) {
                $table->boolean('analytics_status')->default(0);
            }
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
