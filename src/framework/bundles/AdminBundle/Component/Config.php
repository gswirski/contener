<?php

class AdminBundle_Component_Config extends Contener_Component
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
            array('path' => '/admin/config/theme', 'title' => 'Wygląd'),
            array('path' => '/admin/config/plugin', 'title' => 'Wtyczki'),
            array('path' => '/admin/config/editor', 'title' => 'Edytor wizualny'),
        ));
        
        $mainNode = $this->context->area('menu')->findOneBy('path', '/admin/config');
        $mainNode->addPage($navigation);
        
        $navigation = new Contener_View_Widget_Navigation($this->getContainer()->view, $navigation);
        $this->context->area('left')->addModule('Konfiguruj', $navigation);
        
        return '<h2>Konfiguracja</h2>' . $content;
    }
    
    function map($name)
    {
        $name = Doctrine_Inflector::classify($name);
        $name = 'AdminBundle_Component_Config_' . $name;
        return $name;
    }
}
