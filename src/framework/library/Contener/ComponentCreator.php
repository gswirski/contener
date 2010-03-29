<?php

class Contener_ComponentCreator extends k_DefaultComponentCreator
{
    protected $container;
    
    public function __construct($container)
    {
        parent::__construct();
        $this->container = $container;
    }
    
    function create($class_name, k_Context $context, $namespace = "") {
        $component = parent::create($class_name, $context, $namespace);
        $component->setContainer($this->container);
        return $component;
    }
}