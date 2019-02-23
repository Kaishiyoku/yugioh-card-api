<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsForbiddenToMonsterCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('link_monster_cards', function (Blueprint $table) {
            $table->boolean('is_forbidden')->default(false);
        });

        Schema::table('monster_cards', function (Blueprint $table) {
            $table->boolean('is_forbidden')->default(false);
        });

        Schema::table('pendulum_monster_cards', function (Blueprint $table) {
            $table->boolean('is_forbidden')->default(false);
        });

        Schema::table('ritual_monster_cards', function (Blueprint $table) {
            $table->boolean('is_forbidden')->default(false);
        });

        Schema::table('synchro_monster_cards', function (Blueprint $table) {
            $table->boolean('is_forbidden')->default(false);
        });

        Schema::table('xyz_monster_cards', function (Blueprint $table) {
            $table->boolean('is_forbidden')->default(false);
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
            $table->dropColumn('is_forbidden');
        });

        Schema::table('monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_forbidden');
        });

        Schema::table('pendulum_monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_forbidden');
        });

        Schema::table('ritual_monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_forbidden');
        });

        Schema::table('synchro_monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_forbidden');
        });

        Schema::table('xyz_monster_cards', function (Blueprint $table) {
            $table->dropColumn('is_forbidden');
        });
    }
}
