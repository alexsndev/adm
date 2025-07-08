<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('household_tasks', function (Blueprint $table) {
            $table->dateTime('started_at')->nullable()->after('actual_minutes');
            $table->dateTime('paused_at')->nullable()->after('started_at');
        });
    }

    public function down(): void
    {
        Schema::table('household_tasks', function (Blueprint $table) {
            $table->dropColumn(['started_at', 'paused_at']);
        });
    }
}; 