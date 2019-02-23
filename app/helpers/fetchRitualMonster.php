<?php

if (!function_exists('fetchRitualMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    function fetchRitualMonster($cardUrl)
    {
        $cardCarrier = fetchMonster($cardUrl);

        $ritualMonsterCard = new \App\Models\RitualMonsterCard($cardCarrier->getCard()->toArray());

        return new \App\Entities\CardCarrier($ritualMonsterCard, $cardCarrier->getCardSets());
    }
}
