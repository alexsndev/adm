<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('goal_contributions', function (Blueprint $table) {
            $table->unsignedBigInteger('transaction_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('goal_contributions', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
}; 