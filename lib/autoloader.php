<?php

function __autoload($classname)
{
    if (substr($classname, 0,2) == 'sf') {
        require_once('Doctrine/Parser/sfYaml/' . $classname . '.php');
        return;
    }
    $filename = str_replace('_', '/', $classname).'.php';
    require_once($filename);
}