<?php

if (!function_exists('arrMap')) {
    /**
     * @param callable $callback
     * @param array $arr
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
