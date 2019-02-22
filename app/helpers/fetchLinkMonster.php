<?php

if (!function_exists('fetchLinkMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\LinkMonsterCard
     */
    function fetchLinkMonster($cardUrl)
    {
        $monsterCard = fetchMonster($cardUrl);

        $linkMonsterCard = new \App\Models\LinkMonsterCard($monsterCard->toArray());
        $linkMonsterCard->link = $monsterCard->level;

        return $linkMonsterCard;
    }
}
