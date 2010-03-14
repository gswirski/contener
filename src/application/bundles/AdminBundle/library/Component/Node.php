<?php

class AdminBundle_Component_Node extends AdminBundle_Component_Dashboard
{   
    function renderHtml()
    {
        return 'Podgląd strony?';
    }
    
    function renderHtmlAdd()
    {
        ob_start();
        
        return '<h2>Dodaj stronę</h2>
        <p>Under heavy development</p>
        <pre>' . ob_get_clean() . '</pre>';
    }
    
    function renderHtmlEdit($page = null)
    {
        if (!$page) {
            $page = Contener_Domain_Node::fetch($this->query('id'));
        }
        
        $this->context->area('right')->addModule('', Contener_View::create('page_edit_publish')->render($page, array()));
        
        $t = new Contener_View('page_edit');
        return $t->render(
            $this,
            array('page' => $page)
        );
    }
    
    function postForm()
    {
        $_POST['in_navigation'] = (array_key_exists('in_navigation', $_POST) && $_POST['in_navigation'] == 'on') ? true : false;
        $_POST['publish_status'] = (array_key_exists('publish_status', $_POST) && $_POST['publish_status'] == 'on') ? true : false;
        
        $page = Contener_Domain_Node::fetch($this->query('id'));
        
        if ($page->isValid($_POST)) {
            $page->save();
            return new k_SeeOther($this->requestUri());
        } else {
            return $this->renderHtmlEdit($page);
        }
    }
}
