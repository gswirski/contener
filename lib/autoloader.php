<?php

function __autoload($classname)
{
    $filename = str_replace('_', '/', strtolower($classname)).'.php';
    require_once($filename);
}