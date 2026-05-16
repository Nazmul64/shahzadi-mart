<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_seller_chats', function (Blueprint $table) {
            $table->uuid('session_uuid')->nullable()->after('customer_id')->index();
            $table->unsignedBigInteger('customer_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('customer_seller_chats', function (Blueprint $table) {
            $table->dropColumn('session_uuid');
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
        });
    }
};
