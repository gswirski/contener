<?php

class Contener_View_Helper_Navigation extends sfTemplateHelper
{
    protected $_depth = 0;
    
    public function getName()
    {
        return 'navigation';
    }
    
    public function menu($params = array())
    {
        $this->_depth = 0;
        $navigation = $this->getNavigation();
        $params = array_merge(array('min_depth' => 1, 'max_depth' => 0), $params);
        return $this->_renderMenu($navigation, $params);
    }
    
    protected function _renderMenu($navigation, $params)
    {
        $class = '';
        if ($this->_depth == 0) {
            $class = ' class="navigation"';
        }
        
        $this->_depth += 1;
        
        $return = '<ul'.$class.'>';
        foreach ($navigation->getPages() as $page) {
            $active = $page->isActive();
            
            if ($this->_depth < $params['min_depth']) {
                if ($active['tree']) {
                    if ($page->hasChildren()) {
                        $depth = $this->_depth;
                        $return .= $this->_renderMenu($page, $params);
                        $this->_depth = $depth;
                    }
                } else {
                    continue;
                }
            } else {
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
                
                $path = '';
                if (isset($page->path)) {
                    $path = $page->path;
                } else if (isset($page->id)){
                    $path = '/admin/node?edit&id='.$page->id;
                }
                
                if (!isset($page->title)) {
                    print_r($page);
                }
                
                if ($path) {
                    $link = '<a href="' . $this->getHelperSet()->getEngine()->getBaseUrl() . $path.'">'.$page->title.'</a>';
                } else {
                    $link = $page->title;
                }
                
                $return .= '<li'.$class.'>' . $link;
                
                if ($params['max_depth'] == 0 || $this->_depth < $params['max_depth']) {
                    if ($page->hasChildren()) {
                        $depth = $this->_depth;
                        $return .= $this->_renderMenu($page, $params);
                        $this->_depth = $depth;
                    }
                }
                $return .= '</li>';
            }
        }
        $return .= '</ul>';
        return $return;
    }
    
    public function breadcrumbs($params = array())
    {
        
    }
    
    protected function getNavigation()
    {
        return $this->getHelperSet()->getEngine()->getNavigation();
    }
}