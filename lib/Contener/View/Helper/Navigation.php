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
            
            $path = rtrim(str_replace($GLOBALS['baseUrl'], '', $this->requestUri()), '/');
            if ($active = $navigation->findOneBy('path', $path)) {
                
                $active->setActive(true);
            } else if ($this->query('id', false)) {
                //if ($active = $navigation->findOneBy('path', ))
                if ($active = $navigation->findOneBy('id', $this->query('id'))) {
                    $active->setActive(true);
                }
            }
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
                $return .= $this->renderHtml($page);
            }
            
            $return .= '</li>';
        }
        $return .= '</ul>';
        return $return;
    }
}