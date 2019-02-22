<?php

if (!function_exists('fetchRitualMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\RitualMonsterCard
     */
    function fetchRitualMonster($cardUrl)
    {
        $monsterCard = fetchMonster($cardUrl);

        return new \App\Models\RitualMonsterCard($monsterCard->toArray());
    }
}
