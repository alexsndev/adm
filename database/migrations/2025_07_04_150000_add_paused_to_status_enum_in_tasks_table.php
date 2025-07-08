<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Adicionar o valor 'paused' ao enum status
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE tasks MODIFY COLUMN status ENUM('todo', 'in_progress', 'review', 'completed', 'cancelled', 'paused') DEFAULT 'todo'");
        } else if ($driver === 'sqlite') {
            // No SQLite, ENUM não é suportado. Se necessário, pode-se alterar para string ou apenas ignorar.
            // Aqui, apenas ignoramos para evitar erro.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover o valor 'paused' do enum status
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE tasks MODIFY COLUMN status ENUM('todo', 'in_progress', 'review', 'completed', 'cancelled') DEFAULT 'todo'");
        } else if ($driver === 'sqlite') {
            // No SQLite, apenas ignorar.
        }
    }
};
