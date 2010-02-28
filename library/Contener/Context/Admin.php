<?php

class Contener_Context_Admin extends Contener_Context
{
    protected $areas = array();
    
    function dispatch()
    {
        $this->areas['left'] = $this->createComponent('Contener_Context_Admin_Includes_Sidebar', '')->setName('left');
        $this->areas['right'] = $this->createComponent('Contener_Context_Admin_Includes_Sidebar', '')->setName('right');
        
        $this->areas['menu'] = new Contener_Navigation(array(
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
        ));
        
        return parent::dispatch();
    }
    
    function execute() {
        return $this->wrap(parent::execute());
    }
    
    function wrapHtml($content)
    {
        if ($actives = $this->area('menu')->findAllBy('path', $this->path())) {
            foreach ($actives as $active) {
                $active->setActive(true);
            }
        } else if ($active = $this->area('menu')->findOneBy('id', $this->query('id'))){
            $active->setActive(true);
        }
        
        $menu = new Contener_View_Widget_Navigation(array(
            'depth' => 1
        ));
        
        $t = new Contener_View("admin/layout");

        return
          $t->render(
            $this,
            array(
              'content' => $content,
              'menu' => $menu->setNavigation($this->area('menu')),
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
