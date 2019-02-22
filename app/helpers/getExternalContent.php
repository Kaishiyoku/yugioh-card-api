<?php

if (!function_exists('getExternalContent')) {
    /**
     * @param string $url
     * @param string $lang
     * @return string
     */
    function getExternalContent($url, $lang = 'en')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept-Language: ' . $lang]);
        curl_setopt($ch, CURLOPT_URL, $url);

        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
    }
}
