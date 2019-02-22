<?php

if (!function_exists('fetchGermanCardFields')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\LocaleSpecificCard
     */
    function fetchGermanCardFields($cardUrl)
    {
        return fetchLocaleSpecificCardFields($cardUrl, 'de');
    }
}
