<?php

class Contener_Context_Admin extends Contener_Context
{
    protected $areas = array();
    
    function dispatch()
    {
        $this->areas['left'] = $this->createComponent('Contener_Context_Admin_Includes_Sidebar', '')->setName('left');
        $this->areas['right'] = $this->createComponent('Contener_Context_Admin_Includes_Sidebar', '')->setName('right');
        
        return parent::dispatch();
    }
    
    function execute() {
        return $this->wrap(parent::execute());
    }
    
    function wrapHtml($content)
    {
        $menu = $this->createComponent('Contener_View_Helper_Navigation', '')
            ->setNavigation(new Contener_Navigation(array(
                array(
                    'title' => 'Zarządzaj',
                    'path' => '/admin'
                ),
                array(
                    'title' => 'Bloki',
                    'path' => '/admin/block'
                ),
                array(
                    'title' => 'Użytkownicy',
                    'path' => '/admin/user'
                ),
                array(
                    'title' => 'Konfiguracja',
                    'path' => '/admin/config'
                )
            )));
        
        $t = new Contener_View("admin/layout");

        return
          $t->render(
            $this,
            array(
              'content' => $content,
              'menu' => $menu,
              'left' => $this->area('left'),
              'right' => $this->area('right'),
              'title' => 'Panel administracyjny',
              'scripts' => $this->document->scripts(),
              'styles' => $this->document->styles(),
              'onload' => $this->document->onload()));
    }
    
    function renderHtml()
    {
        return $this->forward('Contener_Context_Admin_Dashboard');
    }
    
    function map($name)
    {
        return 'Contener_Context_Admin_' . ucfirst($name);
    }
    
    function area($name)
    {
        return $this->areas[$name];
    }
}