<?php

if (!function_exists('fetchIsForbidden')) {
    /**
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @param \Symfony\Component\CssSelector\CssSelectorConverter $converter
     * @return bool
     */
    function fetchIsForbidden(\Symfony\Component\DomCrawler\Crawler $crawler, \Symfony\Component\CssSelector\CssSelectorConverter $converter)
    {
        $forbiddenNode = $crawler->filterXPath($converter->toXPath('div.forbidden_limited > span'));

        if ($forbiddenNode->count() > 0 && $forbiddenNode->text() == 'Forbidden') {
            return true;
        }

        return false;
    }
}
