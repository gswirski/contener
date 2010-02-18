<?php

class Contener_Navigation extends Contener_Navigation_Container
{
    public function __construct($pages = null)
    {
        if ($pages instanceof Doctrine_Collection) {
            $pages = $pages->toArray();
        }
        
        $this->addPages($pages);
    }
    
    function renderHtml()
    {
        return 'iha';
    }
    
    function __toString()
    {
        return  $this->renderHtml();
    }
}