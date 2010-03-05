<?php

class Contener_Loader
{
    protected $bundles = array();
    
    public function loadFile($file) {
        $basePath = dirname(__FILE__) . '/../../';
        $file = $basePath . $file;
        //$file = get_include_path() . '/' . $file;
        if (file_exists($file)) {
            require_once $file;
            return true;
        } else {
            throw new Exception('File ' . $file . ' does not extsts');
        }
    }
    
    public function loadClass($class)
    {
        if (substr($class, 0, 6) == 'sfYaml') {
            return $this->loadFile('framework/Doctrine/Parser/sfYaml/' . $class . '.php');
        } else if (substr($class, 0, 10) == 'sfTemplate') {
            return $this->loadFile('framework/Templating/'.$class.'.php');
        }
        
        $segments = explode('_', $class);
        $namespace = array_shift($segments);
        
        if (array_key_exists($namespace, $this->bundles)) {
            return $this->loadFile($this->bundles[$namespace] . '/' . implode('/', $segments) . '.php');
        }
        
        return $this->loadFile('framework/' . $namespace . '/' . implode('/', $segments) . '.php');
    }
    
    public function registerBundle($name, $path)
    {
        if (!array_key_exists($name, $this->bundles)) {
            $this->bundles[$name] = trim($path, '/') . '/library';
        }
        
        return $this;
    }
}
