<?php

class AdminBundle_Component_Dashboard extends Contener_Component
{
    protected $repository;
    
    public function __construct()
    {
        $this->repository = new Contener_Database_Repository_Node;
    }
    
    function dispatch()
    {   
        $dashboard = new Contener_Navigation(array(
            array(
                'title' => 'Dashboard',
                'path' => '/admin'
            ),
            array(
                'title' => 'Dodaj stronę',
                'path' => '/admin/node?add'
            )
        ));
        
        $data = $this->repository->listAll();
        $pages = new Contener_Navigation($data);
        
        $mainNode = $this->context->area('menu')->findOneBy('path', '/admin');
        $mainNode->addPage($dashboard);
        $mainNode->addPage($pages);
        
        $dashboard = new Contener_View_Widget_Navigation($this->getService('view'), $dashboard);
        $pages = new Contener_View_Widget_Navigation($this->getService('view'), $pages);
        $this->context->area('left')->addModule('Dashboard', $dashboard);
        $this->context->area('left')->addModule('Zarządzaj stronami', $pages);
        
        return parent::execute();
    }
    
    function renderHtml()
    {
        return $this->getService('view')->render('release_notes');
    }
}
