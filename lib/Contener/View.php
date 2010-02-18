<?php

class Contener_View extends k_Template
{
    function __construct($path)
    {
        $path = 'templates/' . $path . '.php';
        parent::__construct($path);
    }
    
    static function create($path)
    {
        return new self($path);
    }
}

function asset($file, $render = true) {
    $file = $GLOBALS['baseUrl']. '/assets/' . $file;
    if ($render) {
        echo $file;
    }
    return $file;
}