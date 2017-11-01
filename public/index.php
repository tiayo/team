<?php

require_once __DIR__.'/../vendor/autoload.php';

ini_set("display_errors", "off");

if ($_SERVER['REQUEST_URI'] == '/generate/474993693') {
    $view = new \App\ViewController();
    $view->index();
    header("Location: http://".$_SERVER['HTTP_HOST']);
} else {
    echo 'No input file specified.';
}

exit();
