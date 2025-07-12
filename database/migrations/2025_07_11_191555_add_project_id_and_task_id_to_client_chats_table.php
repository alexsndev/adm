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
        Schema::table('client_chats', function (Blueprint $table) {
            if (!Schema::hasColumn('client_chats', 'project_id')) {
                $table->unsignedBigInteger('project_id')->nullable()->after('client_id');
            }
            if (!Schema::hasColumn('client_chats', 'task_id')) {
                $table->unsignedBigInteger('task_id')->nullable()->after('project_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_chats', function (Blueprint $table) {
            $table->dropColumn(['project_id', 'task_id']);
        });
    }
};
