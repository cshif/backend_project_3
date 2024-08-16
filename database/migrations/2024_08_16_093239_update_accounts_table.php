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
        Schema::table('Accounts', function (Blueprint $table) {
            $table->json('user_ids')->default('[]');
            $table->dropColumn('userIds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Accounts', function (Blueprint $table) {
            $table->dropColumn('user_ids');
            $table->json('userIds')->default('[]');
        });
    }
};
