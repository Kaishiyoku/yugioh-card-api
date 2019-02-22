<?php

if (!function_exists('isSameClass')) {
    /**
     * @param $objA
     * @param $objB
     * @return bool
     */
    function isSameClass($objA, $objB)
    {
        return get_class($objA) === get_class($objB);
    }
}
