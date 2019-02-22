<?php

if (!function_exists('fetchSpell')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\SpellCard
     */
    function fetchSpell($cardUrl)
    {
        $card = fetchSpellOrTrap($cardUrl);

        $spellCard = new \App\Models\SpellCard();
        $spellCard->title_german = $card->getTitleGerman();
        $spellCard->title_english = $card->getTitleEnglish();
        $spellCard->icon = $card->getIcon();
        $spellCard->card_text_german = $card->getCardTextGerman();
        $spellCard->card_text_english = $card->getCardTextEnglish();
        $spellCard->url = $cardUrl;

        return $spellCard;
    }
}
