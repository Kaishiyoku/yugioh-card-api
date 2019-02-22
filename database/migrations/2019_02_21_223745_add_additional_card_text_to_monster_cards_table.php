<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalCardTextToMonsterCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monster_cards', function (Blueprint $table) {
            $table->longText('additional_text_german')->nullable();
            $table->longText('additional_text_english')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monster_cards', function (Blueprint $table) {
            $table->dropColumn('additional_text_german');
            $table->dropColumn('additional_text_english');
        });
    }
}
