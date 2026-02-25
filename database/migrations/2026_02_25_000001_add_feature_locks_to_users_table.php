<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_access_plans')->default(true);
            $table->boolean('can_access_stocks')->default(true);
            $table->boolean('can_access_trade')->default(true);
            $table->boolean('can_access_transactions')->default(true);
            $table->boolean('can_access_settings')->default(true);
            $table->boolean('can_access_other')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'can_access_plans',
                'can_access_stocks',
                'can_access_trade',
                'can_access_transactions',
                'can_access_settings',
                'can_access_other',
            ]);
        });
    }
};
