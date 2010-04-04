<?php

class Contener_Bundle
{
    protected $container;
    
    public function install() {}
    public function init() {}
    public function uninstall() {}
    
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