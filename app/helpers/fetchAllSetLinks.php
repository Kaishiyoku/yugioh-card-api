<?php

if (!function_exists('fetchAllSetLinks')) {
    /**
     * @param string $baseUrl
     * @param string $lang
     * @return \Illuminate\Support\Collection
     */
    function fetchAllSetLinks($baseUrl, $lang = null)
    {
        $html = getExternalContent($baseUrl . '/yugiohdb/card_list.action', $lang);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $setLinks = collect($crawler
            ->filterXPath($converter->toXPath('div#card_list_1 div.pack'))
            ->each(function (\Symfony\Component\DomCrawler\Crawler $node) use ($converter, $baseUrl) {
                $title = $node->filterXPath($converter->toXPath('strong'))->text();
                $url = $baseUrl . $node->filterXPath($converter->toXPath('input.link_value[type=hidden]'))->attr('value');

                return new \App\Entities\SetLink($title, $url);
            })
        );

        return $setLinks;
    }
}
