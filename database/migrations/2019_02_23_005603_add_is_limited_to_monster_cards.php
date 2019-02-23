<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsLimitedToMonsterCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('link_monster_cards', function (Blueprint $table) {
            $table->boolean('is_limited')->default(false);
        });

        Schema::table('monster_cards', function (Blueprint $table) {
            $table->boolean('is_limited')->default(false);
        });

        Schema::table('pendulum_monster_cards', function (Blueprint $table) {
            $table->boolean('is_limited')->default(false);
        });

        Schema::table('ritual_monster_cards', function (Blueprint $table) {
            $table->boolean('is_limited')->default(false);
        });

        Schema::table('synchro_monster_cards', function (Blueprint $table) {
            $table->boolean('is_limited')->default(false);
        });

        Schema::table('xyz_monster_cards', function (Blueprint $table) {
            $table->boolean('is_limited')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('link_monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_limited');
        });

        Schema::table('monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_limited');
        });

        Schema::table('pendulum_monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_limited');
        });

        Schema::table('ritual_monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_limited');
        });

        Schema::table('synchro_monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_limited');
        });

        Schema::table('xyz_monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_limited');
        });
    }
}
