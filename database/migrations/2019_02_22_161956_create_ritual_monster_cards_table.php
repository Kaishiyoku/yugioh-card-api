<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRitualMonsterCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ritual_monster_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_german');
            $table->string('title_english');
            $table->string('attribute');
            $table->unsignedInteger('level');
            $table->string('monster_type');
            $table->string('card_type');
            $table->string('atk');
            $table->string('def');
            $table->longText('card_text_german');
            $table->longText('card_text_english');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ritual_monster_cards');
    }
}
