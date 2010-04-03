<?php

class AdminBundle_Context extends Contener_Context
{
    protected $areas = array();
    protected $theme;
    
    public function init()
    {
        $sc = $this->getContainer();
        
        $sc->setParameter(
            'view.loader.paths', dirname(__FILE__) . '/Resources/template/%name%.php');
        
        $sc->view->setBaseUrl($sc->getParameter('request.base_url'));
    }
    
    function dispatch()
    {
        $this->areas['left'] = $this->createComponent('AdminBundle_Widget_Sidebar', '')->setName('left');
        $this->areas['right'] = $this->createComponent('AdminBundle_Widget_Sidebar', '')->setName('right');
        
        $this->areas['menu'] = new Contener_Navigation(array(
            array(
                'title' => 'Zarządzaj',
                'path' => '/admin'
            ),
            array(
                'title' => 'Media',
                'path' => '/admin/media'
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
        
        $menu = new Contener_View_Widget_Navigation(null, null, array(
            'depth' => 1
        ));
        
        $view = $this->getContainer()->view;
        
        return
          $view->render(
            'layout',
            array(
              'context' => $this,
              'content' => $content,
              'menu' => $menu->setView($view)->setNavigation($this->area('menu')),
              'left' => $this->area('left'),
              'right' => $this->area('right'),
              'title' => 'Panel administracyjny',
              'scripts' => $this->document->scripts(),
              'styles' => $this->document->styles(),
              'onload' => $this->document->onload()));
    }
    
    function renderHtml()
    {
        return $this->forward('AdminBundle_Component_Dashboard');
    }
    
    function map($name)
    {
        return 'AdminBundle_Component_' . ucfirst($name);
    }
    
    function area($name)
    {
        return $this->areas[$name];
    }
    
    public function getTheme()
    {
        if (!$this->theme) {
            $repository = new Contener_Database_Repository_Theme();
            $this->theme = $repository->findOneBy('is_active', true);
        }
        
        return $this->theme;
    }
}
