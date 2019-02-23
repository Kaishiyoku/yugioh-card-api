<?php

if (!function_exists('fetchPendulumMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\PendulumMonsterCard
     */
    function fetchPendulumMonster($cardUrl)
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

        $pendulumMonsterCard = new \App\Models\PendulumMonsterCard();
        $pendulumMonsterCard->title_german = $germanCardFields->getTitle();
        $pendulumMonsterCard->title_english = $englishCardFields->getTitle();
        $pendulumMonsterCard->attribute = $tabularDetails[0];
        $pendulumMonsterCard->level = intval($tabularDetails[1]);
        $pendulumMonsterCard->pendulum_scale = intval($boxDetails[0]);
        $pendulumMonsterCard->pendulum_effect_german = $germanCardFields->getAdditionalText();
        $pendulumMonsterCard->pendulum_effect_english = $englishCardFields->getAdditionalText();
        $pendulumMonsterCard->monster_type = $boxDetails[1];
        $pendulumMonsterCard->card_type = removeWhiteSpaces($boxDetails[2]);
        $pendulumMonsterCard->atk = $tabularDetails[2];
        $pendulumMonsterCard->def = $tabularDetails[3];
        $pendulumMonsterCard->card_text_german = $germanCardFields->getCardText();
        $pendulumMonsterCard->card_text_english = $englishCardFields->getCardText();
        $pendulumMonsterCard->url = $cardUrl;
        $pendulumMonsterCard->is_forbidden = fetchIsForbidden($crawler, $converter);
        $pendulumMonsterCard->is_limited = fetchIsLimited($crawler, $converter);

        return $pendulumMonsterCard;
    }
}
