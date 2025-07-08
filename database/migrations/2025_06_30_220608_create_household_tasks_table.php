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
        Schema::create('household_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('assigned_to', ['alexandre', 'liza', 'both'])->default('both'); // Quem deve fazer
            $table->enum('frequency', ['once', 'daily', 'weekly', 'monthly'])->default('once');
            $table->date('due_date')->nullable();
            $table->time('due_time')->nullable();
            $table->date('completed_date')->nullable();
            $table->integer('estimated_minutes')->nullable(); // Tempo estimado
            $table->integer('actual_minutes')->default(0); // Tempo real gasto
            $table->text('notes')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->integer('order')->default(0); // Para ordenação
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_tasks');
    }
};
