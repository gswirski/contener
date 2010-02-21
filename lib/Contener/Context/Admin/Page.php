<?php

class Contener_Context_Admin_Page extends Contener_Context_Admin_Dashboard
{   
    function renderHtml()
    {
        return 'Podgląd strony?';
    }
    
    function renderHtmlAdd()
    {
        return '<h2>Dodaj stronę</h2><p>To be implemented</p>';
    }
    
    function renderHtmlEdit()
    {
        $page = Contener_Domain_Page::fetch($this->query('id'));
        $page = new $page['class']($page);
        
        $this->context->area('right')->addModule('', Contener_View::create('admin/page_edit_publish')->render($page, array()));
        
        $t = new Contener_View('admin/page_edit');
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