<?php

class AdminBundle_Component_Config_Theme extends Contener_Component
{
    protected $repository;
    
    public function init()
    {
        $this->getService('loader')->loadClass('Contener_Domain_ThemeTable');
        $this->repository = new Contener_Database_Repository_Theme();
    }
    
    function renderHtml()
    {
        $list = $this->repository->listAll($this->query('name', null), $this->config('loader.base_dir'));
        $theme = $this->getSubject($this->query('name', false));
        
        return $this->getService('view')->render('config/theme/select', array('context' => $this, 'selected' => $theme, 'list' => $list));
    }
    
    function renderHtmlActivate()
    {
        $this->repository->activate($this->query('name'));
        return new k_SeeOther(str_replace('activate', 'select', $this->requestUri()));
    }
    
    function renderHtmlEdit()
    {
        $list = $this->repository->listAll($this->query('name', null), $this->config('loader.base_dir'));
        $theme = $this->getSubject($this->query('name', false));
        
        return $this->getService('view')->render(
            'config/theme/edit',
            array(
                'context' => $this,
                'selected' => $theme,
                'list' => $list
            )
        );
    }
    
    function postMultipart()
    {
        $theme = $this->getSubject($this->query('name', false));
        $config = $theme->getConfig($this->config('loader.base_dir'));
        
        $valid = true;
        
        $slots = new Contener_Slot_Manager(array('name' => 'theme'));
        $slots->addSlots($config['slots']);
        $theme->setSlotManager($slots);
        
        foreach ($slots as $name => $slot) {
            $valid = $slot->isValid($_POST['slots'][$name]) && $valid;
        }
        
        if ($valid) {
            $this->repository->store($theme);
            return new k_SeeOther($this->requestUri());
        }
        
        return $this->renderHtml();
    }
    
    protected function getSubject($name = false)
    {
        if ($name) {
            $config = include $this->config('loader.base_dir') . '/application/themes/' . $name . '/theme.php';
        } else {
            $config = $this->getTheme()->getConfig($this->config('loader.base_dir'));
        }
        $this->repository->setThemeConfig($config);
        
        return $this->repository->findOneBy('name', $this->query('name', null));
    }
}
