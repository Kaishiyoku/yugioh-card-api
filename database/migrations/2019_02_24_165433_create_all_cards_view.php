<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllCardsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE ALGORITHM=UNDEFINED VIEW `all_cards` AS
                SELECT
	                CONCAT('link-', id) AS gid,
	                'link' AS 'type',
	                title_german,
	                title_english,
	                card_text_german,
	                card_text_english,
	                url,
	                created_at,
	                updated_at
                FROM link_monster_cards
                UNION ALL
                SELECT
	                CONCAT('basic-', id) AS gid,
	                'basic' AS 'type',
	                title_german,
	                title_english,
	                card_text_german,
	                card_text_english,
	                url,
	                created_at,
	                updated_at
                FROM monster_cards
                UNION ALL
                SELECT
	                CONCAT('pendulum-', id) AS gid, 
                    'pendulum' AS 'type',
                    title_german,
                    title_english,
                    card_text_german,
                    card_text_english,
                    url,
                    created_at,
                    updated_at
                FROM pendulum_monster_cards
                UNION ALL
                SELECT
                    CONCAT('ritual-', id) AS gid,
                    'ritual' AS 'type',
                    title_german,
                    title_english,
                    card_text_german,
                    card_text_english,
                    url,
                    created_at,
                    updated_at
                FROM ritual_monster_cards
                UNION ALL
                SELECT
                    CONCAT('synchro-', id) AS gid,
                    'synchro' AS 'type',
                    title_german,
                    title_english,
                    card_text_german,
                    card_text_english,
                    url,
                    created_at,
                    updated_at
                FROM synchro_monster_cards
                UNION ALL
                SELECT
                    CONCAT('xyz-', id) AS gid,
                    'xyz' AS 'type',
                    title_german,
                    title_english,
                    card_text_german,
                    card_text_english,
                    url,
                    created_at,
                    updated_at
                FROM xyz_monster_cards
                UNION ALL
                SELECT
                    CONCAT('spell-', id) AS gid,
                    'spell' AS 'type',
                    title_german,
                    title_english,
                    card_text_german,
                    card_text_english,
                    url,
                    created_at,
                    updated_at
                FROM spell_cards
                UNION ALL
                SELECT
                    CONCAT('trap-', id) AS gid,
                    'trap' AS 'type',
                    title_german,
                    title_english,
                    card_text_german,
                    card_text_english,
                    url,
                    created_at,
                    updated_at
                FROM trap_cards
        ;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view `all_cards`');
    }
}
