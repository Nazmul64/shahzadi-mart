<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Employees ──
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('nid')->nullable();
            $table->decimal('starting_salary', 12, 2);
            $table->decimal('current_salary', 12, 2);
            $table->date('joining_date');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // ── Attendance ──
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // ── Salary Advances ──
        Schema::create('salary_advances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('month'); // e.g., '2026-05'
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // ── Salaries (Payments) ──
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('month'); // '2026-05'
            $table->decimal('base_salary', 12, 2);
            $table->integer('present_days');
            $table->integer('absent_days');
            $table->decimal('advances', 12, 2)->default(0);
            $table->decimal('deductions', 12, 2)->default(0);
            $table->decimal('bonuses', 12, 2)->default(0);
            $table->decimal('net_payable', 12, 2);
            $table->boolean('is_paid')->default(false);
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });

        // ── Expenses ──
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->string('category');
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('salaries');
        Schema::dropIfExists('salary_advances');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('employees');
    }
};
