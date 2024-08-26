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
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('balance_before_transaction')->nullable()->change();
            $table->bigInteger('balance_after_transaction')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('balance_before_transaction')->nullable(false)->change();
            $table->bigInteger('balance_after_transaction')->nullable(false)->change();
        });
    }
};
