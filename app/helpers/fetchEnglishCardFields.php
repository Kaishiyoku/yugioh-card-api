<?php

if (!function_exists('fetchEnglishCardFields')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\LocaleSpecificCard
     */
    function fetchEnglishCardFields($cardUrl)
    {
        return fetchLocaleSpecificCardFields($cardUrl, 'en');
    }
}
