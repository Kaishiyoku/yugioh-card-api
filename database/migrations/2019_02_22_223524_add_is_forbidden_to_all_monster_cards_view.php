<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsForbiddenToAllMonsterCardsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('drop view `all_monster_cards`');

        DB::statement("
            CREATE ALGORITHM=UNDEFINED VIEW `all_monster_cards` AS
                SELECT
	                CONCAT('link-', id) AS gid,
	                'link' AS 'type',
	                title_german,
	                title_english,
	                attribute,
	                NULL AS level,
	                link,
	                NULL AS rank,
	                NULL AS pendulum_scale,
	                NULL AS pendulum_effect_german,
	                NULL AS pendulum_effect_english,
	                monster_type,
	                card_type,
	                atk,
	                def,
	                card_text_german,
	                card_text_english,
	                url,
	                is_forbidden,
	                created_at,
	                updated_at
                FROM link_monster_cards
                UNION ALL
                SELECT
	                CONCAT('basic-', id) AS gid,
	                'basic' AS 'type',
	                title_german,
	                title_english,
	                attribute,
	                level,
                    NULL AS link,
	                NULL AS rank,
	                NULL AS pendulum_scale,
	                NULL AS pendulum_effect_german,
	                NULL AS pendulum_effect_english,
	                monster_type,
	                card_type,
	                atk,
	                def,
	                card_text_german,
	                card_text_english,
	                url,
	                is_forbidden,
	                created_at,
	                updated_at
                FROM monster_cards
                UNION ALL
                SELECT
	                CONCAT('pendulum-', id) AS gid, 
                    'pendulum' AS 'type',
                    title_german,
                    title_english,
                    attribute,
                    level,
                    NULL AS link,
                    NULL AS rank,
                    pendulum_scale,
                    pendulum_effect_german,
                    pendulum_effect_english,
                    monster_type,
                    card_type,
                    atk,
                    def,
                    card_text_german,
                    card_text_english,
                    url,
                    is_forbidden,
                    created_at,
                    updated_at
                FROM pendulum_monster_cards
                UNION ALL
                SELECT
                    CONCAT('ritual-', id) AS gid,
                    'ritual' AS 'type',
                    title_german,
                    title_english,
                    attribute,
                    level,
                    NULL AS link,
                    NULL AS rank,
                    NULL AS pendulum_scale,
                    NULL AS pendulum_effect_german,
                    NULL AS pendulum_effect_english,
                    monster_type,
                    card_type,
                    atk,
                    def,
                    card_text_german,
                    card_text_english,
                    url,
                    is_forbidden,
                    created_at,
                    updated_at
                FROM ritual_monster_cards
                UNION ALL
                SELECT
                    CONCAT('synchro-', id) AS gid,
                    'synchro' AS 'type',
                    title_german,
                    title_english,
                    attribute,
                    level,
                    NULL AS link,
                    NULL AS rank,
                    NULL AS pendulum_scale,
                    NULL AS pendulum_effect_german,
                    NULL AS pendulum_effect_english,
                    monster_type,
                    card_type,
                    atk,
                    def,
                    card_text_german,
                    card_text_english,
                    url,
                    is_forbidden,
                    created_at,
                    updated_at
                FROM synchro_monster_cards
                UNION ALL
                SELECT
                    CONCAT('xyz-', id) AS gid,
                    title_german,
                    title_english,
                    attribute,
                    NULL AS level,
                    NULL AS link,
                    rank,
                    NULL AS link,
                    NULL AS pendulum_scale,
                    NULL AS pendulum_effect_german,
                    NULL AS pendulum_effect_english,
                    monster_type,
                    card_type,
                    atk,
                    def,
                    card_text_german,
                    card_text_english,
                    url,
                    is_forbidden,
                    created_at,
                    updated_at
                FROM xyz_monster_cards
        ;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view `all_monster_cards`');

        DB::statement("
            CREATE ALGORITHM=UNDEFINED VIEW `all_monster_cards` AS
                SELECT
	                CONCAT('link-', id) AS gid,
	                'link' AS 'type',
	                title_german,
	                title_english,
	                attribute,
	                NULL AS level,
	                link,
	                NULL AS rank,
	                NULL AS pendulum_scale,
	                NULL AS pendulum_effect_german,
	                NULL AS pendulum_effect_english,
	                monster_type,
	                card_type,
	                atk,
	                def,
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
	                attribute,
	                level,
                    NULL AS link,
	                NULL AS rank,
	                NULL AS pendulum_scale,
	                NULL AS pendulum_effect_german,
	                NULL AS pendulum_effect_english,
	                monster_type,
	                card_type,
	                atk,
	                def,
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
                    attribute,
                    level,
                    NULL AS link,
                    NULL AS rank,
                    pendulum_scale,
                    pendulum_effect_german,
                    pendulum_effect_english,
                    monster_type,
                    card_type,
                    atk,
                    def,
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
                    attribute,
                    level,
                    NULL AS link,
                    NULL AS rank,
                    NULL AS pendulum_scale,
                    NULL AS pendulum_effect_german,
                    NULL AS pendulum_effect_english,
                    monster_type,
                    card_type,
                    atk,
                    def,
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
                    attribute,
                    level,
                    NULL AS link,
                    NULL AS rank,
                    NULL AS pendulum_scale,
                    NULL AS pendulum_effect_german,
                    NULL AS pendulum_effect_english,
                    monster_type,
                    card_type,
                    atk,
                    def,
                    card_text_german,
                    card_text_english,
                    url,
                    created_at,
                    updated_at
                FROM synchro_monster_cards
                UNION ALL
                SELECT
                    CONCAT('xyz-', id) AS gid,
                    title_german,
                    title_english,
                    attribute,
                    NULL AS level,
                    NULL AS link,
                    rank,
                    NULL AS link,
                    NULL AS pendulum_scale,
                    NULL AS pendulum_effect_german,
                    NULL AS pendulum_effect_english,
                    monster_type,
                    card_type,
                    atk,
                    def,
                    card_text_german,
                    card_text_english,
                    url,
                    created_at,
                    updated_at
                FROM xyz_monster_cards
        ;");
    }
}
