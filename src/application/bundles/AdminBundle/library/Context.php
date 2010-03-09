<?php

class AdminBundle_Context extends Contener_Context
{
    protected $areas = array();
    
    public function __construct()
    {
        $loader = new sfTemplateLoaderFilesystem(dirname(__FILE__) . '/../resources/template/%name%.php');
        Contener_View::setEngine( new sfTemplateEngine($loader) );
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
        
        $menu = new Contener_View_Widget_Navigation(array(
            'depth' => 1
        ));
        
        $t = new Contener_View("layout");

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
}
