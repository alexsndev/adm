<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            // $table->string('logo')->nullable()->after('user_id'); // Comentado para evitar erro de coluna duplicada
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            // $table->dropColumn('logo'); // Comentado para evitar erro
        });
    }
}; 