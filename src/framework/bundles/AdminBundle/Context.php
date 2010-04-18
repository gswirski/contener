<?php

class AdminBundle_Context extends Contener_Context
{
    protected $areas = array();
    protected $theme;
    
    public function init()
    {
        $sc = $this->getContainer();
        
        $sc->getService('view.loader')->setPaths(dirname(__FILE__) . '/Resources/template/%name%.php');
        
        $view = $sc->getService('view');
        $view->setBaseUrl($sc->getParameter('request.base_url'));
        $view->getHelperSet()->set(new Contener_View_Helper_Navigation());
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
        
        $this->getService('view')->setNavigation($this->areas['menu']);
        
        return parent::dispatch();
    }
    
    function execute() {
        return $this->wrap(parent::execute());
    }
    
    function wrapHtml($content)
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return $content;
        }
        
        if ($actives = $this->area('menu')->findAllBy('path', $this->path())) {
            foreach ($actives as $active) {
                $active->setActive(true);
            }
        } else if ($active = $this->area('menu')->findOneBy('id', $this->query('id'))){
            $active->setActive(true);
        }
        
        $view = $this->getService('view');
        
        $menu = $view->navigation->menu(array('min_depth' => 2));
        
        if ($menu != '<ul class="navigation"></ul>') {
            $this->area('left')->addModule('', $menu);
        }
        
        return
          $view->render(
            'layout',
            array(
              'context' => $this,
              'content' => $content,
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
