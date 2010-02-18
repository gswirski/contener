<?php

class Contener_Context_Admin_Page extends Contener_Component
{
    function renderHtml()
    {
        return 'Podgląd strony?';
    }
    
    function renderHtmlEdit()
    {
        $page = Contener_Domain_Page::fetch($this->query('id'));
        $page = new $page['class']($page);
        
        $this->context->sidebar('right')->addModule('', Contener_View::create('admin/page_edit_publish')->render($this, array()));
        
        $t = new Contener_View('admin/page_edit');
        return $t->render(
            $this,
            array('page' => $page)
        );
    }
    
    function postForm()
    {
        $page = Contener_Domain_Page::fetch($this->query('id'));
        $page = new $page['class']($page);
        
        if ($page->isValid($_POST)) {
            $page->save();
        }
    }
}