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
            $page = $this->getNode($this->query('id'));
        }
        
        $this->context->area('right')->addModule('', Contener_View::create('page_edit_publish')->render($page, array('theme' => $this->getTheme())));
        
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
        
        $page = $this->getNode($this->query('id'));
        
        if ($page->isValid($_POST)) {
            $this->repository->store($page);
            return new k_SeeOther($this->requestUri());
        } else {
            return $this->renderHtmlEdit($page);
        }
    }
    
    protected function getNode($id)
    {
        $themeConfig = $this->getTheme()->getConfig($this->config('loader.base_dir'));
        $this->repository->setThemeConfig($themeConfig);
        return $this->repository->findOneBy('id', $id);
    }
}
