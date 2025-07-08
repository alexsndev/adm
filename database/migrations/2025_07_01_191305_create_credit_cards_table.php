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
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nome do cartão (ex: Nubank, Itaú, etc.)
            $table->string('brand'); // Bandeira (Visa, Mastercard, etc.)
            $table->string('last_four_digits', 4)->nullable(); // Últimos 4 dígitos
            $table->decimal('credit_limit', 15, 2)->nullable(); // Limite de crédito
            $table->decimal('current_balance', 15, 2)->default(0); // Saldo atual
            $table->date('due_date')->nullable(); // Data de vencimento da fatura
            $table->string('logo')->nullable(); // Caminho da imagem/logo
            $table->string('color')->nullable(); // Cor do cartão
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
