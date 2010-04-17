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
        $navigation = $this->getService('view')->getNavigation();
        $navigation->findOneBy('path', '/admin/config')->addPages(array(
            array('title' => '<h3 class="opened">Konfiguruj</h3>', 'pages' => array(
                array('path' => '/admin/config', 'title' => 'Ogólne'),
                array('path' => '/admin/config/theme', 'title' => 'Wygląd'),
                array('path' => '/admin/config/plugin', 'title' => 'Wtyczki'),
                array('path' => '/admin/config/editor', 'title' => 'Edytor wizualny')
            ))
        ));
        
        return '<h2>Konfiguracja</h2>' . $content;
    }
    
    function map($name)
    {
        $name = Doctrine_Inflector::classify($name);
        $name = 'AdminBundle_Component_Config_' . $name;
        return $name;
    }
}
