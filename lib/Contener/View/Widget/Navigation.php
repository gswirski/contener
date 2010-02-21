<?php

class Contener_View_Widget_Navigation
{
    protected $navigation;
    
    public function setNavigation(Contener_Navigation_Container $navigation) {
        $this->navigation = $navigation;
        return $this;
    }
    
    public function render(Contener_Navigation_Container $navigation = null)
    {
        $class = '';
        if (!$navigation) {
            $navigation = $this->navigation;
            $class = ' class="navigation"';
        }
        
        $return = '<ul'.$class.'>';
        foreach ($navigation->getPages() as $page) {
            $active = $page->isActive();
            
            $class = array();
            if ($active['page']) {
                $class[] = 'active_page';
            }
            if ($active['tree']) {
                $class[] = 'active_tree';
            }
            
            if ($class) {
                $class = ' class="'.implode(' ', $class).'"';
            } else {
                $class = '';
            }
            
            if (isset($page->path)) {
                $path = $page->path;
            } else {
                $path = '/admin/page?edit&id='.$page->id;
            }
            
            $return .= '<li'.$class.'><a href="'.$GLOBALS['baseUrl'].$path.'">'.$page->title.'</a>';
            
            if ($page->hasChildren()) {
                $return .= $this->render($page);
            }
            
            $return .= '</li>';
        }
        $return .= '</ul>';
        return $return;
    }
    
    public function __toString()
    {
        return $this->render();
    }
}