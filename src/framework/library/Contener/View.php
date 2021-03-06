<?php

class Contener_View extends sfTemplateEngine
{
    protected $baseUrl;
    protected $container;
    protected $navigation;
    
    public function getContainer()
    {
        return $this->container;
    }
    
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }
    
    public function getNavigation()
    {
        return $this->navigation;
    }
    
    public function setNavigation(Contener_Navigation_Container $navigation)
    {
        $this->navigation = $navigation;
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
    
    public function installAssets($name, $source = '')
    {
        if (!is_array($name)) {
            $name = array($name => $source);
        }
        
        foreach ($name as $destination => $source) {
            $handler = new Contener_Application_Data($source, Contener_Application_Data::WEB);
            $handler->symlink('assets/' . $destination);
        }
    }
    
    public function uninstallAsset($name, $namespace = '')
    {
    }
}

