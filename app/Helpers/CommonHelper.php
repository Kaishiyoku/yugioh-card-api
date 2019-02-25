<?php

namespace App\Helpers;

class CommonHelper
{
    /**
     * @param string|null $str
     * @return int
     */
    public static function filterInt($str)
    {
        preg_match("/-?[0-9]+/", $str, $matches);

        if (count($matches) == 0) {
            return null;
        }

        return $matches[0];
    }

    /**
     * @param string $url
     * @param string $lang
     * @return string
     */
    public static function getExternalContent($url, $lang = 'en')
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

    /**
     * @param $objA
     * @param $objB
     * @return bool
     */
    public static function isSameClass($objA, $objB)
    {
        return get_class($objA) === get_class($objB);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function removeWhiteSpaces($str)
    {
        return str_replace(["\t", "\r", "\n"], '', $str);
    }
}