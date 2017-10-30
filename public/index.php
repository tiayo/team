<?php

require_once __DIR__.'/../vendor/autoload.php';

ini_set("display_errors", "off");

if ($_SERVER['REQUEST_URI'] == '/') {
    $view = new \App\ViewController();

    echo $view->index();
}

echo 'No input file specified.';
exit();
