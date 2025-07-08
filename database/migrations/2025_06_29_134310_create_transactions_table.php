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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 15, 2); // valor da transação
            $table->enum('type', ['income', 'expense', 'transfer']); // tipo: receita, despesa ou transferência
            $table->date('date'); // data da transação
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('transfer_account_id')->nullable()->constrained('accounts')->onDelete('cascade'); // conta de destino para transferências
            $table->text('notes')->nullable(); // observações
            $table->string('reference')->nullable(); // referência (número do cheque, etc)
            $table->boolean('is_recurring')->default(false); // transação recorrente
            $table->string('recurring_frequency')->nullable(); // frequência (monthly, weekly, etc)
            $table->date('recurring_end_date')->nullable(); // data de fim da recorrência
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('debt_id')->nullable()->constrained('debts')->onDelete('set null');
            $table->timestamps();
            
            // Índices para consultas frequentes
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'category_id']);
            $table->index(['account_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
