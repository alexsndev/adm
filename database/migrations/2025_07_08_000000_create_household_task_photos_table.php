<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('household_task_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_task_id')->constrained()->onDelete('cascade');
            $table->string('photo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('household_task_photos');
    }
}; 