<?php

class AdminBundle_Component_Node extends AdminBundle_Component_Dashboard
{   
    function renderHtml() {}
    function renderHtmlAdd($page = null)
    {
        
        // Just to cache data [another thing that sucks and will be fixed when Dependency Injection Container implemented]
        $themeConfig = $this->getTheme()->getConfig($this->config('loader.base_dir'));
        if (!$page) {
            $page = new Contener_Node();
        }
        
        if ($template = $page->template) {
            if (isset($themeConfig['templates']) && isset($themeConfig['templates'][$template]) && isset($themeConfig['templates'][$template]['slots'])) {
                $slots = $themeConfig['templates'][$template]['slots'];
                if (isset($themeConfig['templates'][$template]['is_open']) && $themeConfig['templates'][$template]['is_open']) {
                    $page->getSlotManager()->addSlots($slots);
                } else {
                    $page->getSlotManager()->setSlots($slots);
                }
            }
        }
        
        $theme = $this->getTheme();
        
        $this->context->area('right')->addModule('', $this->getService('view')->render(
            'page_edit_publish', 
            array('context' => $page, 'theme' => $theme, 'show_template' => false))
        );
        
        return $this->getService('view')->render(
            'page_add',
            array('context' => $this, 'page' => $page, 'list' => $this->repository->listAll('flat'), 'theme' => $theme)
        );
    }
    
    function renderHtmlEdit($page = null)
    {   
        if (!$page) {
            $page = $this->getNode($this->query('id'), $this->query('template'));
        }
        
        if ($this->query('template') !== null) {
            $page->template = $this->query('template');
        }
        
        $this->context->area('right')->addModule('', $this->getService('view')->render(
            'page_edit_publish', 
            array('context' => $page, 'theme' => $this->getTheme()))
        );
        
        return $this->getService('view')->render(
            'page_edit',
            array('context' => $this, 'page' => $page)
        );
    }
    
    function postMultipart()
    {
        $data = $this->requestData();
        $query = $this->query();
        
        $queryKeys = array_keys($query);
        $subtype = array_shift($queryKeys);
        
        if ($subtype == 'add') {
            if (array_key_exists('new_node_reload', $data)) {
                $node = new Contener_Node();
                $node->template = $data['new_node_template'];
                return $this->renderHtmlAdd($node);
            } else if (array_key_exists('publish', $data)) {
                
            }
        } elseif ($subtype == 'edit') {
            $_POST['in_navigation'] = (array_key_exists('in_navigation', $_POST) && $_POST['in_navigation'] == 'on') ? true : false;
            $_POST['publish_status'] = (array_key_exists('publish_status', $_POST) && $_POST['publish_status'] == 'on') ? true : false;
            
            $page = $this->getNode($this->query('id'), $this->query('template'));
            $page->template = $this->query('template', $page->template);
            
            if ($page->isValid($data)) {
                $this->repository->store($page);
                return new k_SeeOther($this->requestUri());
            } else {
                return $this->renderHtmlEdit($page);
            }
        }
    }
    
    public function postMultipartAdd()
    {
        echo 'działa';
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
