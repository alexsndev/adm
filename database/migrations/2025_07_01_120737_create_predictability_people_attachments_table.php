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
        Schema::create('predictability_people_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('predictability_people')->onDelete('cascade');
            $table->string('arquivo');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictability_people_attachments');
    }
};
