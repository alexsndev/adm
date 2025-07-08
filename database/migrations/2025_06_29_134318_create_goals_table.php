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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('target_amount', 15, 2); // valor alvo
            $table->decimal('current_amount', 15, 2)->default(0); // valor atual
            $table->date('target_date'); // data limite
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->string('color', 7)->default('#10B981'); // cor em hex
            $table->string('icon')->nullable(); // ícone
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Índices
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'target_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
