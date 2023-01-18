<?php

if (!function_exists('faNum')) {
    function faNum($num)
    {
        $pattern = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return preg_replace_callback('![0-9]!', function($w) use ($pattern) {
            return $pattern[$w[0]];
        }, $num);
    }
}

if (!function_exists('enNum'))
{
    function enNum($num)
    {
        $pattern = ['۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'];
        return str_replace(array_keys($pattern), array_values($pattern), $num);
    }
}

if (!function_exists('jalali'))
{
    function jalali($date, $format)
    {
        return jdate($date)->format($format);
    }
}