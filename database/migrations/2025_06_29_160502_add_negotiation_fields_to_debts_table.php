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
        Schema::table('debts', function (Blueprint $table) {
            $table->decimal('negotiated_amount', 15, 2)->nullable()->after('current_balance');
            $table->integer('installments')->nullable()->after('negotiated_amount');
            $table->decimal('installment_amount', 15, 2)->nullable()->after('installments');
            $table->date('agreement_date')->nullable()->after('installment_amount');
            $table->boolean('is_negotiated')->default(false)->after('agreement_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('debts', function (Blueprint $table) {
            $table->dropColumn([
                'negotiated_amount',
                'installments', 
                'installment_amount',
                'agreement_date',
                'is_negotiated'
            ]);
        });
    }
};
