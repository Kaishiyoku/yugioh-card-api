<?php

if (!function_exists('fetchSynchroMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\SynchroMonsterCard
     */
    function fetchSynchroMonster($cardUrl)
    {
        $monsterCard = fetchMonster($cardUrl);

        return new \App\Models\SynchroMonsterCard($monsterCard->toArray());
    }
}
