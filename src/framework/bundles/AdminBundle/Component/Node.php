<?php

class AdminBundle_Component_Node extends AdminBundle_Component_Dashboard
{   
    function renderHtml() {}
    function renderHtmlAdd() {}
    
    function renderHtmlEdit($page = null)
    {   
        if (!$page) {
            $page = $this->getNode($this->query('id'), $this->query('template'));
        }
        
        if ($this->query('template') !== null) {
            $page->template = $this->query('template');
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
        
        $page = $this->getNode($this->query('id'), $this->query('template'));
        $page->template = $this->query('template', $page->template);
        
        if ($page->isValid($_POST)) {
            $this->repository->store($page);
            return new k_SeeOther($this->requestUri());
        } else {
            return $this->renderHtmlEdit($page);
        }
    }
    
    protected function getNode($id, $template = null, $buildEntity = true)
    {
        $themeConfig = $this->getTheme()->getConfig($this->config('loader.base_dir'));
        $this->repository->setThemeConfig($themeConfig);
        if ($template !== null) {
            $this->repository->setTemplate($template);
        }
        return $this->repository->findOneBy('id', $id, $buildEntity);
    }
    
    public function renderHtmlDelete()
    {
        $node = $this->getNode($this->query('id'), null, false);
        $before = $this->repository->findOneBy('lft', $node->lft - 1);
        $node->getNode()->delete();
        return new k_SeeOther(str_replace(array('delete', $this->query('id')), array('edit', $before->id), $this->requestUri()));
    }
}
