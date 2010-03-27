<?php

class AdminBundle_Component_Config_Theme extends Contener_Component
{
    protected $repository;
    
    public function init()
    {
        $GLOBALS['loader']->loadClass('Contener_Domain_ThemeTable');
        $this->repository = new Contener_Database_Repository_Theme();
    }
    
    function renderHtml()
    {
        $list = $this->repository->listAll($this->query('name', null), $this->config('loader.base_dir'));
        $theme = $this->repository->findOneBy('name', $this->query('name', null));
        
        $config = include $this->config('loader.base_dir') . '/application/themes/' . $theme->name . '/theme.php';
        
        $valid = true;
        
        $slots = new Contener_Slot_Manager(array('name' => 'theme'));
        
        return Contener_View::create('config/theme/select')->render($this, array('selected' => $theme, 'list' => $list));
    }
    
    function renderHtmlActivate()
    {
        $this->repository->activate($this->query('name'));
        return new k_SeeOther(str_replace('activate', 'select', $this->requestUri()));
    }
    
    function renderHtmlEdit()
    {
        $list = $this->repository->listAll($this->query('name', null), $this->config('loader.base_dir'));
        $theme = $this->repository->findOneBy('name', $this->query('name', null));
        $config = include $this->config('loader.base_dir') . '/' . $theme->file_path . '/theme.php';
        
        return Contener_View::create('config/theme/edit')
            ->render($this, array(
                'selected' => $theme,
                'list' => $list
            ));
    }
    
    function postForm()
    {
        $theme = $this->repository->findOneBy('name', $this->query('name', null));
        $config = include $this->config('loader.base_dir') . '/' . $theme->file_path . '/theme.php';
        
        $valid = true;
        
        $slots = new Contener_Slot_Manager(array('name' => 'theme'));
        foreach ($config['slots'] as $name => $slot) {
            $slot->setName($name);
            $slots->addSlot($slot);
            
            $valid = $slot->isValid($_POST['theme'][$name]) && $valid;
        }
        
        $theme->setSlotManager($slots);
        
        if ($valid) {
            $this->repository->store($theme);
        }
        
        return $this->renderHtml();
    }
}
