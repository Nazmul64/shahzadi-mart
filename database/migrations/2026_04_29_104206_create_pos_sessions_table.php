<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_sessions', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('invoice_no')->unique();

            // Relations
            $table->foreignId('customer_id')
                  ->nullable()
                  ->constrained('customers')
                  ->nullOnDelete();

            $table->unsignedBigInteger('created_by')->nullable();

            // Amounts
            $table->decimal('sub_total', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('shipping_amount', 12, 2)->default(0);
            $table->decimal('coupon_discount', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            // Coupon
            $table->string('coupon_code')->nullable();

            // Status & Payment
            $table->enum('status', ['draft', 'completed', 'cancelled'])
                  ->default('draft');

            $table->enum('payment_method', ['cash', 'card', 'mobile_banking'])
                  ->default('cash');

            // Extra
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_sessions');
    }
};
