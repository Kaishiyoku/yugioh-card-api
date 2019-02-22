<?php

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
