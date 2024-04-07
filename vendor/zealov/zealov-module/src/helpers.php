<?php

if (!function_exists('starts_with')) {
    function starts_with($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle != '' && mb_strpos($haystack, $needle) === 0) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('ends_with')) {
    function ends_with($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ((string)$needle === mb_substr($haystack, -mb_strlen($needle))) {
                return true;
            }
        }
        return false;
    }
}
