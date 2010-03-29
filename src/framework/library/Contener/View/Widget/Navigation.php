<?php

class Contener_View_Widget_Navigation
{
    protected $navigation;
    protected $params = array();
    protected $_depth = 0;
    
    public function __construct(array $params = array())
    {
        $defaults = array(
            'depth' => 10
        );
        
        $this->params = array_merge($defaults, $params);
    }
    
    public function setNavigation(Contener_Navigation_Interface $navigation) {
        $this->navigation = $navigation;
        return $this;
    }
    public function render(Contener_Navigation_Interface $navigation = null)
    {
        $class = '';
        if (!$navigation) {
            $navigation = $this->navigation;
            $class = ' class="navigation"';
            $this->_depth = 1;
        } else {
            $this->_depth += 1;
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
                $path = '/admin/node?edit&id='.$page->id;
            }
            
            $return .= '<li'.$class.'><a href="' . Contener_View::getBaseUrl() . $path.'">'.$page->title.'</a>';
            
            if ($this->_depth < $this->params['depth']) {
            
                if ($page->hasChildren()) {
                    $return .= $this->render($page);
                }
            
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
