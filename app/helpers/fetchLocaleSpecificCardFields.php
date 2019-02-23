<?php

if (!function_exists('fetchLocaleSpecificCardFields')) {
    /**
     * @param string $cardUrl
     * @param string $lang
     * @return \App\Entities\LocaleSpecificCard
     */
    function fetchLocaleSpecificCardFields($cardUrl, $lang)
    {
        $html = getExternalContent($cardUrl, $lang);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $boxDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box_text'))
            ->each(childrenRemover());

        $title = $crawler->filterXPath($converter->toXPath('nav#pan_nav > ul > li:nth-child(3)'))->text();

        $cardText = $boxDetails[0];
        $additionalText = null;

        if (count($boxDetails) > 1) {
            $additionalText = $boxDetails[0];
            $cardText = $boxDetails[1];
        }

        $cardSets = fetchLocalizedCardSets($crawler);

        return new \App\Entities\LocaleSpecificCard($title, $cardText, $additionalText, $cardSets);
    }
}
