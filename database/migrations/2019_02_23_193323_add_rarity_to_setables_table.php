<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRarityToSetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setables', function (Blueprint $table) {
            $allowedRarities = [
                'Hobby',
                'Common',
                'Rare',
                'Super Rare',
                'Ultra Rare',
                'Ultimate Rare',
                'Secret Rare',
                'Ghost Rare',
                'Gold Rare',
            ];

            $table->enum('rarity', $allowedRarities);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setables', function (Blueprint $table) {
            $table->dropColumn('rarity');
        });
    }
}
