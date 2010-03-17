<?php

class Contener_View
{
    protected static $engine;
    protected $path;
    
    public function __construct($path = '')
    {
        if ($path) {
            $this->path = $path;
        }
    }
    
    public function render($context = null, $model = array())
    {
        return self::$engine->render($this->path, array_merge(array('context' => $context), $model));
    }
    
    public static function create($path)
    {
        return new self($path);
    }
    
    public static function getEngine()
    {
        return self::$engine;
    }
    
    public static function setEngine($object)
    {
        self::$engine = $object;
    }
}

function asset($file, $render = true) {
    $file = $GLOBALS['baseUrl']. '/' . $file;
    if ($render) {
        echo $file;
    }
    return $file;
}

function url_for($file, $render = true) {
    $file = $GLOBALS['baseUrl']. '/' . $file;
    if ($render) {
        echo $file;
    }
    return $file;
}