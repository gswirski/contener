<?php

class Contener_View extends sfTemplateEngine
{
    protected $baseUrl;
    protected $container;
    
    public function getContainer()
    {
        return $this->container;
    }
    
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }
    
    public function getWidget($class)
    {
        $widget = new $class;
        $widget->setView($this);
        return $widget;
    }
    
    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;
        return $this;
    }
    
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    
    public function registerStylesheet($name, $path)
    {
        return $this->registerAsset($name, $path, 'style');
    }
    
    public function unregisterStylesheet($name)
    {
        return $this->unregisterAsset($name, 'style');
    }
    
    public function registerJavascript($name, $path)
    {
        return $this->registerAsset($name, $path, 'script');
    }
    
    public function unregisterJavascript($name)
    {
        return $this->unregisterAsset($name, 'script');
    }
    
    public function registerAsset($name, $path, $namespace = '')
    {
        
    }
    
    public function unregisterAsset($name, $namespace = '')
    {
        
    }
}
