<?php

if (!function_exists('arrEach')) {
    /**
     * @param callable $callback
     * @param array $arr
     */
    function arrEach(callable $callback, array $arr): void
    {
        foreach ($arr as $key => $item) {
            $callback($item, $key);
        }
    }

}