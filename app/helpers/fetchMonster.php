<?php

if (!function_exists('fetchMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\MonsterCard
     */
    function fetchMonster($cardUrl)
    {
        $germanCardFields = fetchGermanCardFields($cardUrl);
        $englishCardFields = fetchEnglishCardFields($cardUrl);
        $html = getExternalContent($cardUrl);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $tabularDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box > span.item_box_value'))
            ->each(function (\Symfony\Component\DomCrawler\Crawler $node) {
                return trim($node->text());
            });
        $boxDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box.t_center'))
            ->each(childrenRemover());

        $monsterCard = new \App\Models\MonsterCard();
        $monsterCard->title_german = $germanCardFields->getTitle();
        $monsterCard->title_english = $englishCardFields->getTitle();
        $monsterCard->attribute = $tabularDetails[0];
        $monsterCard->level = intval($tabularDetails[1]);
        $monsterCard->monster_type = $boxDetails[0];
        $monsterCard->card_type = removeWhiteSpaces($boxDetails[1]);
        $monsterCard->atk = $tabularDetails[2];
        $monsterCard->def = $tabularDetails[3];
        $monsterCard->card_text_german = $germanCardFields->getCardText();
        $monsterCard->card_text_english = $englishCardFields->getCardText();
        $monsterCard->url = $cardUrl;
        $monsterCard->is_forbidden = fetchIsForbidden($crawler, $converter);

        return $monsterCard;
    }
}
