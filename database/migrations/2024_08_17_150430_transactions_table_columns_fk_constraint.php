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
            $table
                ->foreign('source_account_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table
                ->foreign('destination_account_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign([
                'source_account_id',
                'destination_account_id',
            ]);
        });
    }
};
