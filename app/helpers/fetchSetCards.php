<?php

if (!function_exists('fetchSetCards')) {
    /**
     * @param string $baseUrl
     * @param string $setUrl
     * @param string $lang
     * @return \Illuminate\Support\Collection
     */
    function fetchSetCards($baseUrl, $setUrl, $lang = null)
    {
        $html = getExternalContent($setUrl, $lang);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $setCards = collect($crawler
            ->filterXPath($converter->toXPath('ul.box_list > li'))
            ->each(function (\Symfony\Component\DomCrawler\Crawler $node) use ($baseUrl, $converter) {
                $cardInfoNode = $node->filterXPath($converter->toXPath('dd.box_card_spec > span.card_info_species_and_other_item'));

                $url = $baseUrl . $node->filterXPath($converter->toXPath('input.link_value[type=hidden]'))->attr('value');
                $attribute = trim($node->filterXPath($converter->toXPath('dd.box_card_spec > span.box_card_attribute'))->text());
                $cardInfo = $cardInfoNode->count() == 1 ? removeWhiteSpaces($cardInfoNode->text()) : null;

                return new \App\Entities\SetCard($url, $attribute, $cardInfo);
            })
        );

        return $setCards;
    }
}
