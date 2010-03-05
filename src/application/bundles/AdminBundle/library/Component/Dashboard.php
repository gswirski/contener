<?php

class AdminBundle_Component_Dashboard extends Contener_Component
{
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
        
        $data = Doctrine_Query::create()
            ->select()
            ->from('Contener_Domain_Node p')
            ->where('p.level != ?', 0)
            ->orderBy('p.lft')
            ->execute(array(), Doctrine_Core::HYDRATE_RECORD_HIERARCHY);
        $pages = new Contener_Navigation($data);
        
        $mainNode = $this->context->area('menu')->findOneBy('path', '/admin');
        $mainNode->addPage($dashboard);
        $mainNode->addPage($pages);
        
        $this->context->area('left')->addModule('Dashboard', $dashboard);
        $this->context->area('left')->addModule('Zarządzaj stronami', $pages);
        
        return parent::execute();
    }
    
    function renderHtml()
    {
        $t = new Contener_View('release_notes');
        
        return $t->render();
    }
}
