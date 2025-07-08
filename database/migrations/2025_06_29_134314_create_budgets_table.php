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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2); // valor do orçamento
            $table->decimal('spent', 15, 2)->default(0); // valor gasto
            $table->integer('month'); // mês (1-12)
            $table->integer('year'); // ano
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Índices
            $table->index(['user_id', 'year', 'month']);
            $table->index(['category_id', 'year', 'month']);
            
            // Garantir que não há duplicatas
            $table->unique(['user_id', 'category_id', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
