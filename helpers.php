<?php

if (!function_exists('dd')) {
    function dd($data)
    {
        var_dump($data);
        exit();
    }
}

if (!function_exists('config')) {
    function config($key)
    {
        $config = include __DIR__.'/config.php';

        return $config[$key];
    }
}

if (!function_exists('response')) {
    function response($message, $code)
    {
       http_response_code($code);
       echo $message;
       exit();
    }
}

