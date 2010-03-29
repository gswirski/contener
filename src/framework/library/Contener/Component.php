<?php

class Contener_Component extends k_Component 
{
    protected $container;
    
    public function dispatch()
    {
        $this->init();
        
        return parent::dispatch();
    }
    public function init() {}
    
    public function __toString()
    {
        return (string) $this->renderHtml();
    }
    
    public function config($path = null, $default = null)
    {
        return $this->getContainer()->getParameter($path);
    }
    
    public function getTheme()
    {
        return $this->context->getTheme();
    }
    
    public function baseUrl()
    {
        return $this->getContainer()->getParameter('request.base_url');
    }
    
    public function path()
    {
        return rtrim(str_replace($this->baseUrl(), '', $this->requestUri()), '/');
    }
    
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }
    
    public function getContainer()
    {
        return $this->container;
    }
}
