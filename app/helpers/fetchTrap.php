<?php

if (!function_exists('fetchTrap')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    function fetchTrap($cardUrl)
    {
        $card = fetchSpellOrTrap($cardUrl);

        $trapCard = new \App\Models\TrapCard();
        $trapCard->title_german = $card->getTitleGerman();
        $trapCard->title_english = $card->getTitleEnglish();
        $trapCard->icon = $card->getIcon();
        $trapCard->card_text_german = $card->getCardTextGerman();
        $trapCard->card_text_english = $card->getCardTextEnglish();
        $trapCard->url = $cardUrl;
        $trapCard->is_forbidden = $card->isForbidden();
        $trapCard->is_limited = $card->isLimited();

        return new \App\Entities\CardCarrier($trapCard, $card->getCardSets());
    }
}
