<?php

class Contener_Context_Admin extends Contener_Context
{
    protected $sidebars = array();
    
    function dispatch()
    {
        $this->sidebars['left'] = $this->createComponent('Contener_Context_Admin_Includes_Sidebar', '');
        $this->sidebars['right'] = $this->createComponent('Contener_Context_Admin_Includes_Sidebar', '');
        
        return parent::dispatch();
    }
    
    function execute() {
        return $this->wrap(parent::execute());
    }
    
    function wrapHtml($content)
    {   
        $data = Doctrine_Query::create()
            ->select()
            ->from('Contener_Domain_Page p')
            ->where('p.level != ?', 0)
            ->orderBy('p.lft')
            ->execute(array(), Doctrine_Core::HYDRATE_RECORD_HIERARCHY);
        $navigation = new Contener_Navigation($data);
        
        $helper = $this->createComponent('Contener_View_Helper_Navigation', '')
            ->setNavigation($navigation);
        
        $this->sidebar('left')->addModule('Zarządzaj stronami', $helper);
        
        $t = new Contener_View("admin/layout");

        return
          $t->render(
            $this,
            array(
              'content' => $content,
              'left' => $this->sidebar('left'),
              'right' => $this->sidebar('right'),
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
    
    function sidebar($name)
    {
        return $this->sidebars[$name];
    }
}