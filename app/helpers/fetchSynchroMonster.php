<?php

if (!function_exists('fetchSynchroMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    function fetchSynchroMonster($cardUrl)
    {
        $cardCarrier = fetchMonster($cardUrl);

        $synchroMonsterCard = new \App\Models\SynchroMonsterCard($cardCarrier->getCard()->toArray());

        return new \App\Entities\CardCarrier($synchroMonsterCard, $cardCarrier->getCardSets());
    }
}
