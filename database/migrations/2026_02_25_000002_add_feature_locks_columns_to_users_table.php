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
            if (!Schema::hasColumn('users', 'can_access_plans')) {
                $table->boolean('can_access_plans')->default(true);
            }
            if (!Schema::hasColumn('users', 'can_access_stocks')) {
                $table->boolean('can_access_stocks')->default(true);
            }
            if (!Schema::hasColumn('users', 'can_access_trade')) {
                $table->boolean('can_access_trade')->default(true);
            }
            if (!Schema::hasColumn('users', 'can_access_transactions')) {
                $table->boolean('can_access_transactions')->default(true);
            }
            if (!Schema::hasColumn('users', 'can_access_settings')) {
                $table->boolean('can_access_settings')->default(true);
            }
            if (!Schema::hasColumn('users', 'can_access_other')) {
                $table->boolean('can_access_other')->default(true);
            }
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
            if (Schema::hasColumn('users', 'can_access_plans')) {
                $table->dropColumn('can_access_plans');
            }
            if (Schema::hasColumn('users', 'can_access_stocks')) {
                $table->dropColumn('can_access_stocks');
            }
            if (Schema::hasColumn('users', 'can_access_trade')) {
                $table->dropColumn('can_access_trade');
            }
            if (Schema::hasColumn('users', 'can_access_transactions')) {
                $table->dropColumn('can_access_transactions');
            }
            if (Schema::hasColumn('users', 'can_access_settings')) {
                $table->dropColumn('can_access_settings');
            }
            if (Schema::hasColumn('users', 'can_access_other')) {
                $table->dropColumn('can_access_other');
            }
        });
    }
};
