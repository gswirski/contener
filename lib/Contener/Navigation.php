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
    
    public function isActive()
    {
        if ($this->active) {
            return array('page' => true, 'tree' => true);
        } else {
            foreach ($this->pages as $page) {
                $sub = $page->isActive();
                if ($sub['tree']) {
                    return array('page' => false, 'tree' => true);
                }
            }
            
            foreach ($this->subNavigations as $subNavigation) {
                $sub = $subNavigation->isActive();
                if ($sub['tree']) {
                    return array('page' => false, 'tree' => true);
                } 
            }
        }
        return array('page' => false, 'tree' => false);
    }
    
    public function __toString()
    {
        $view = new Contener_View_Widget_Navigation();
        return $view->setNavigation($this)->render();
    }
}