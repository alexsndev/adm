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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('original_amount', 15, 2);
            $table->decimal('current_balance', 15, 2);
            $table->decimal('interest_rate', 5, 2)->default(0); // Taxa de juros mensal
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['active', 'paid', 'defaulted'])->default('active');
            $table->date('due_date')->nullable();
            $table->date('start_date');
            $table->string('creditor_name')->nullable();
            $table->string('creditor_contact')->nullable();
            $table->string('contract_number')->nullable();
            $table->enum('debt_type', ['credit_card', 'personal_loan', 'mortgage', 'car_loan', 'student_loan', 'business_loan', 'other'])->default('other');
            $table->boolean('is_consolidated')->default(false);
            $table->json('payment_history')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'priority']);
            $table->index(['due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
