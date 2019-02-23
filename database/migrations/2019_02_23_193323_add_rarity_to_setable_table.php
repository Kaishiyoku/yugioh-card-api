<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRarityToSetableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setable', function (Blueprint $table) {
            $allowedRarities = [
                'Common',
                'Rare',
                'Super Rare',
                'Ultra Rare',
                'Ultimate Rare',
                'Secret Rare',
                'Ghost Rare',
            ];

            $table->enum('rarity', $allowedRarities)->default('Common');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setable', function (Blueprint $table) {
            $table->dropColumn('rarity');
        });
    }
}
