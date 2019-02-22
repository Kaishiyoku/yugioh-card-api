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

        return $matches[0];
    }
}
