<?php

class Loader
{
    protected $config = array();
    
    protected $namespaces = array();
    protected $extensions = array();
    
    public function __construct($config = array()) {
        $defaults = array(
            'base_dir' => ''
        );
        
        $this->config = array_merge($defaults, $config);
    }
    
    public function registerBundle($name, $path)
    {
        return $this->registerNamespace($name, $path);
    }
    
    public function registerNamespace($name, $path)
    {
        $this->namespaces[$name] = $path;
        return $this;
    }
    
    public function registerExtension($name, $callable)
    {
        $this->extensions[$name] = $callable;
        return $this;
    }
    
    public function loadClass($class)
    {
        $parts = explode('_', $class);
        if (array_key_exists($ns = array_shift($parts), $this->namespaces)) {
            $result = $this->loadFile($this->namespaces[$ns] . '/' . implode('/', $parts) . '.php');
            if (class_exists($class) or interface_exists($class)) {
                return $result;
            }
        }
        
        foreach ($this->extensions as $extension) {
            if (is_callable($extension)) {
                if ($result = call_user_func($extension, $class, $this)) {
                    return $result;
                }
            }
        }
        
        return false;
    }
    
    public function loadFile($name)
    {
        $file = $this->config['base_dir'] . '/' . $name;
        if (file_exists($file)) {
            include $file;
            return true;
        } else {
            echo $file;
        }
        
        return false;
    }
}