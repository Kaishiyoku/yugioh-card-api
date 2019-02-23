<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsLimitedToSpellAndTrapCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spell_cards', function (Blueprint $table) {
            $table->boolean('is_limited')->default(true);
        });

        Schema::table('trap_cards', function (Blueprint $table) {
            $table->boolean('is_limited')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spell_cards', function (Blueprint $table) {
            $table->dropColumn('is_limited')->default(true);
        });

        Schema::table('trap_cards', function (Blueprint $table) {
            $table->dropColumn('is_limited')->default(true);
        });
    }
}
