<?php

class Contener_Context_Admin_Includes_Sidebar extends Contener_Component
{
    protected $modules = array();
    
    function addModule($title, $module)
    {
        $this->modules[] = array('title' => $title, 'component' => $module);
    }
    
    function getModules()
    {
        return $this->modules;
    }
    
    function renderHtml()
    {
        $return = '';
        foreach ($this->modules as $module) {
            if ($module['title']) {
                $return .= '<h3 class="opened">' . $module['title'] . '</h3>';
            }
            
            $return .= $module['component'];
        }
        
        return $return;
        
        //return '<ul><li>' . implode('</li><li>', $this->modules) . '</li></ul>';
    }
}