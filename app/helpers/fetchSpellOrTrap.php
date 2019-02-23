<?php

if (!function_exists('fetchSpellOrTrap')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\Card
     */
    function fetchSpellOrTrap($cardUrl)
    {
        $germanCardFields = fetchGermanCardFields($cardUrl);
        $englishCardFields = fetchEnglishCardFields($cardUrl);
        $html = getExternalContent($cardUrl);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $tabularDetails = $crawler->filterXPath($converter->toXPath('table#details div.item_box'))->each(childrenRemover());

        return new \App\Entities\Card(
            $germanCardFields->getTitle(),
            $englishCardFields->getTitle(),
            $tabularDetails[0],
            $germanCardFields->getCardText(),
            $englishCardFields->getCardText(),
            fetchIsForbidden($crawler, $converter)
        );
    }
}
