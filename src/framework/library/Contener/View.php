<?php

class Contener_View
{
    protected static $engine;
    protected static $baseUrl = '/';
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
    
    public static function getBaseUrl()
    {
        return self::$baseUrl;
    }
    
    public static function setBaseUrl($url)
    {
        self::$baseUrl = $url;
    }
}