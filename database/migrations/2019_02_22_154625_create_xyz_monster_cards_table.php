<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXyzMonsterCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xyz_monster_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_german');
            $table->string('title_english');
            $table->string('attribute');
            $table->unsignedInteger('rank');
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
        Schema::dropIfExists('xyz_monster_cards');
    }
}
