<?php

class Contener_View extends sfTemplateEngine
{
    protected $baseUrl;
    
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
}