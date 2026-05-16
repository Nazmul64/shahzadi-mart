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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('photo')->after('phone')->nullable();
            $table->string('nid_photo')->after('nid')->nullable();
            $table->string('father_name')->after('nid_photo')->nullable();
            $table->string('mother_name')->after('father_name')->nullable();
            $table->string('father_phone')->after('mother_name')->nullable();
            $table->string('village')->after('father_phone')->nullable();
            $table->string('district')->after('village')->nullable();
            $table->string('thana')->after('district')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['photo', 'nid_photo', 'father_name', 'mother_name', 'father_phone', 'village', 'district', 'thana']);
        });
    }

};
