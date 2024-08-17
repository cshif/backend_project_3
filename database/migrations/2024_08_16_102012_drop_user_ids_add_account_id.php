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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('account_id')->after('remember_token');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('user_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->json('user_ids')->default('[]')->after('balance');
        });
    }
};
