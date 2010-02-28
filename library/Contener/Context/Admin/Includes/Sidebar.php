<?php

class Contener_Context_Admin_Includes_Sidebar extends Contener_Component
{
    protected $modules = array();
    protected $name;
    
    function addModule($title, $module)
    {
        $this->modules[] = array('title' => $title, 'component' => $module);
    }
    
    function getModules()
    {
        return $this->modules;
    }
    
    function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    function renderHtml()
    {
        if (!$this->modules) {
            return;
        }
        $return = '<div class="'.$this->name.'-sidebar">';
        foreach ($this->modules as $module) {
            if ($module['title']) {
                $return .= '<h3 class="opened">' . $module['title'] . '</h3>';
            }
            
            $return .= $module['component'];
        }
        $return .= '</div>';
        
        return $return;
        
        //return '<ul><li>' . implode('</li><li>', $this->modules) . '</li></ul>';
    }
}
