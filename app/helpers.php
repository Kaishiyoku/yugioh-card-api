<?php

if (!function_exists('filterInt')) {
    /**
     * @param string|null $str
     * @return int
     */
    function filterInt($str)
    {
        preg_match("/-?[0-9]+/", $str, $matches);

        if (count($matches) == 0) {
            return null;
        }

        dd($matches[0]);

        return $matches[0];
    }
}

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

if (!function_exists('arrEach')) {
    /**
     * @param callable $callback
     * @param array    $arr
     */
    function arrEach(callable $callback, array $arr): void
    {
        foreach ($arr as $key => $item) {
            $callback($item, $key);
        }
    }
}

if (!function_exists('arrMap')) {
    /**
     * @param callable $callback
     * @param array    $arr
     * @return array
     */
    function arrMap(callable $callback, array $arr): array
    {
        $newArray = [];

        foreach ($arr as $key => $item) {
            $newArray[$key] = $callback($item, $key);
        }

        return $newArray;
    }
}

if (!function_exists('arrReduce')) {
    /**
     * @param callable $callback
     * @param array $arr
     * @param null|mixed $initial
     * @return mixed
     */
    function arrReduce(callable $callback, array $arr, $initial = null)
    {
        return array_reduce($arr, $callback, $initial);
    }
}