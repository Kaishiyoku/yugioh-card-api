<?php

if (!function_exists('fetchXyzMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\XyzMonsterCard
     */
    function fetchXyzMonster($cardUrl)
    {
        $monsterCard = fetchMonster($cardUrl);

        $xyzMonsterCard = new \App\Models\XyzMonsterCard($monsterCard->toArray());
        $xyzMonsterCard->rank = $monsterCard->level;

        return $xyzMonsterCard;
    }
}
