<?php

if (!function_exists('fetchLocalizedCardSets')) {
    /**
     * @param \Symfony\Component\DomCrawler\Crawler $node
     * @return \Illuminate\Support\Collection<\App\Entities\CardSet>
     */
    function fetchLocalizedCardSets(\Symfony\Component\DomCrawler\Crawler $node)
    {
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        return collect($node->filterXPath($converter->toXPath('div#pack_list tr.row'))->each(function (\Symfony\Component\DomCrawler\Crawler $subNode) use ($converter) {
            $values = $subNode->filterXPath($converter->toXPath('td'))->each(function (\Symfony\Component\DomCrawler\Crawler $subSubNode) {
                return trim($subSubNode->text());
            });

            $identifiers = explode('-', $values[1]);

            $setIdentifier = $identifiers[0];
            $cardIdentifier = $identifiers[1];
            $title = $values[2];

            return new \App\Entities\CardSet($setIdentifier, $cardIdentifier, $title);
        }));
    }
}