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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['birthday', 'anniversary', 'holiday', 'custom'])->default('custom');
            $table->enum('recurrence_type', ['yearly', 'monthly', 'weekly', 'daily', 'once'])->default('yearly');
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Para eventos que não são recorrentes
            $table->time('time')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('reminder_days')->default(7); // Dias de antecedência para lembrete
            $table->string('color')->default('#3B82F6'); // Cor para o calendário
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
}; 