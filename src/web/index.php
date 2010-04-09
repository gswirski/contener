<?php

function microtime_float()
{
    list($utime, $time) = explode(" ", microtime());
    return ((float)$utime + (float)$time);
}

$script_start = microtime_float();

require_once '../application/bootstrap.php';
$app = new Application('dev');
$app->run();

$script_end = microtime_float();
echo "Script executed in ".bcsub($script_end, $script_start, 4)." seconds.";
