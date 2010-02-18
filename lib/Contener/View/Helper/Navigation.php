<?php

class Contener_View_Helper_Navigation extends Contener_Component
{
    protected $navigation;
    
    public function setNavigation(Contener_Navigation_Container $navigation)
    {
        $this->navigation = $navigation;
        
        return $this;
    }
    
    public function renderHtml(Contener_Navigation_Container $navigation = null)
    {   
        $class = '';
        if (!$navigation) {
            $navigation = $this->navigation;
            $class = ' class="navigation"';
        }
        $return = '<ul'.$class.'>';
        foreach ($navigation->getPages() as $page) {
            $return .= '<li><a href="'.$GLOBALS['baseUrl'].'/admin/page?edit&id='.$page->id.'">'.$page->title.'</a>';
            
            if ($page->hasChildren()) {
                $return .= $this->renderHtml($page);
            }
            
            $return .= '</li>';
        }
        $return .= '</ul>';
        return $return;
        return '<p>to be implemented</p>';
    }
}