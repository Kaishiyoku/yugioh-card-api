<?php

if (!function_exists('fetchXyzMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    function fetchXyzMonster($cardUrl)
    {
        $cardCarrier = fetchMonster($cardUrl);

        $xyzMonsterCard = new \App\Models\XyzMonsterCard($cardCarrier->getCard()->toArray());
        $xyzMonsterCard->rank = $cardCarrier->getCard()->level;

        return new \App\Entities\CardCarrier($xyzMonsterCard, $cardCarrier->getCardSets());
    }
}
