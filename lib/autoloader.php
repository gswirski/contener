<?php

function loadClass($classname)
{
    if (substr($classname, 0, 6) == 'sfYaml') {
        require_once('Doctrine/Parser/sfYaml/' . $classname . '.php');
        return;
    } else if (substr($classname, 0, 10) == 'sfTemplate') {
        require_once('Templating/'.$classname.'.php');
        return;
    }
    $filename = str_replace('_', '/', $classname).'.php';
    require_once($filename);
}

spl_autoload_register('loadClass');