<?php

class Contener_View
{
    protected static $engine;
    protected $path;
    
    public function __construct($path = '')
    {
        if (!self::$engine) {
            $loader = new sfTemplateLoaderFilesystem(APPLICATION_DIR . '/templates/%name%.php');
            self::$engine = new sfTemplateEngine($loader);
        }
        
        if ($path) {
            $this->path = $path;
        }
    }
    
    public function render($context, $model = array())
    {
        return self::$engine->render($this->path, array_merge(array('context' => $context), $model));
    }
    
    public static function create($path)
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