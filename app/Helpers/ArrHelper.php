<?php

namespace App\Helpers;

class ArrHelper
{
    /**
     * @param callable $callback
     * @param array $arr
     */
    public static function each(callable $callback, array $arr): void
    {
        foreach ($arr as $key => $item) {
            $callback($item, $key);
        }
    }

    /**
     * @param callable $callback
     * @param array $arr
     * @return array
     */
    public static function map(callable $callback, array $arr): array
    {
        $newArray = [];

        foreach ($arr as $key => $item) {
            $newArray[$key] = $callback($item, $key);
        }

        return $newArray;
    }

    /**
     * @param callable $callback
     * @param array $arr
     * @param null|mixed $initial
     * @return mixed
     */
    function reduce(callable $callback, array $arr, $initial = null)
    {
        return array_reduce($arr, $callback, $initial);
    }
}