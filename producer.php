<?php

require_once(__DIR__ . "/vendor/autoload.php");
require_once(__DIR__ . "/config.php");


$kernel = new App\Producer('127.0.0.1', '6666');
$kernel->main();
