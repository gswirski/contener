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
        $navigation = $this->getService('view')->getNavigation();
        $navigation->findOneBy('path', '/admin')->addPages(array(
            array(
                'title' => '<h3 class="opened">Dashboard</h3>',
                'pages' => array(
                    array(
                        'title' => 'Dashboard',
                        'path' => '/admin'
                    ),
                    array(
                        'title' => 'Dodaj stronę',
                        'path' => '/admin/node?add'
                    )
                )
            ),
            array(
                'title' => '<h3 class="opened" style="margin-top: 15px;">Zarządzaj stronami</h3>',
                'pages' => $this->repository->listAll()
            )
        ));
        
        return parent::dispatch();
    }
    
    function renderHtml()
    {
        return $this->getService('view')->render('release_notes');
    }
}
