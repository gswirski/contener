<?php

class Contener_Context_Admin_Config extends Contener_Component
{
    function execute() {
        return $this->wrap(parent::execute());
    }
    
    function renderHtml()
    {
        return '';
    }
    
    function wrapHtml($content)
    {
        $navigation = new Contener_Navigation(array(
            array('path' => '/admin/config', 'title' => 'Ogólne'),
            array('path' => '/admin/config/page_type', 'title' => 'Typy stron'),
            array('path' => '/admin/config/templates', 'title' => 'Szablony'),
            array('path' => '/admin/config/plugin', 'title' => 'Wtyczki'),
            array('path' => '/admin/config/editor', 'title' => 'Edytor wizualny'),
        ));
        $this->context->area('left')->addModule('Konfiguruj', $navigation);
        
        return '<h2>Konfiguracja</h2>' . $content;
    }
    
    function map($name)
    {
        $name = Doctrine_Inflector::classify($name);
        $name = 'Contener_Context_Admin_Config_' . $name;
        return $name;
    }
}