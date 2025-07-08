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
        Schema::create('financial_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('target_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->enum('goal_type', [
                'emergency_fund', 
                'debt_free', 
                'savings', 
                'investment', 
                'eco_friendly_home', 
                'solar_panels', 
                'electric_vehicle', 
                'sustainable_business', 
                'green_investment', 
                'education', 
                'travel', 
                'retirement', 
                'other'
            ])->default('savings');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['active', 'completed', 'paused', 'cancelled'])->default('active');
            $table->date('target_date');
            $table->date('start_date');
            $table->decimal('monthly_contribution', 15, 2)->default(0);
            $table->string('color')->default('#10B981'); // Verde por padrão
            $table->string('icon')->nullable();
            $table->json('milestones')->nullable(); // Marcos intermediários
            $table->boolean('is_eco_friendly')->default(false);
            $table->text('eco_impact_description')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'goal_type']);
            $table->index(['target_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_goals');
    }
};
