<?php

class Contener_Navigation_Node extends Contener_Navigation_Container
{
    public function __construct($page)
    {
        if ($page instanceof Doctrine_Record) {
            $page = $page->toArray();
        }
        
        foreach ($page as $paramName => $paramValue) {
            if ($paramName == 'pages' or $paramName == '__children') {
                $this->addPages($page[$paramName]);
                continue;
            }
            
            $this->$paramName = $paramValue;
        }
    }
    
    public function getClass()
    {
        
    }
}
