<?php

if (!function_exists('fetchLinkMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    function fetchLinkMonster($cardUrl)
    {
        $cardCarrier = fetchMonster($cardUrl);

        $linkMonsterCard = new \App\Models\LinkMonsterCard($cardCarrier->getCard()->toArray());
        $linkMonsterCard->link = $cardCarrier->getCard()->level;

        return new \App\Entities\CardCarrier($linkMonsterCard, $cardCarrier->getCardSets());
    }
}
