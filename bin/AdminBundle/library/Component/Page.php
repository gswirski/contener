<?php

class AdminBundle_Component_Page extends AdminBundle_Component_Dashboard
{   
    function renderHtml()
    {
        return 'Podgląd strony?';
    }
    
    function renderHtmlAdd()
    {
        ob_start();
        
        $configurator = new Contener_Domain_PageType_Configurator();
        $configurator->setClass('Contener_Page');
        $configurator->setSlotManager('Contener_Slot_Manager_Template', array('file' => 'homepage'));
        $configurator->setTemplates(array());
        print_r($configurator->getData());
        
        return '<h2>Dodaj stronę</h2>
        <p>Under heavy development</p>
        <pre>' . ob_get_clean() . '</pre>';
    }
    
    function renderHtmlEdit()
    {
        $page = Contener_Domain_Page::fetch($this->query('id'));
        $page = new $page['class']($page);
        
        $this->context->area('right')->addModule('', Contener_View::create('page_edit_publish')->render($page, array()));
        
        $t = new Contener_View('page_edit');
        return $t->render(
            $this,
            array('page' => $page)
        );
    }
    
    function postForm()
    {
        $_POST['in_navigation'] = ($_POST['in_navigation'] == 'on') ? true : false;
        $_POST['publish_status'] = ($_POST['publish_status'] == 'on') ? true : false;
        
        $page = Contener_Domain_Page::fetch($this->query('id'));
        $page = new $page['class']($page);
        
        if ($page->isValid($_POST)) {
            $page->save();
        }
    }
}
