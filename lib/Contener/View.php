<?php

class Contener_View extends k_Template
{
    
}

function asset($file, $render = true) {
    $file = 'assets/' . $file;
    if ($render) {
        echo $file;
    }
    return $file;
}