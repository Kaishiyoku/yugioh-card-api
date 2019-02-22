<?php

if (!function_exists('removeWhiteSpaces')) {
    /**
     * @param string $str
     * @return string
     */
    function removeWhiteSpaces($str)
    {
        return str_replace(["\t", "\r", "\n"], '', $str);
    }
}
