<?php

class AdminBundle_Component_Config_Theme extends Contener_Component
{
    protected $domain;
    
    public function init()
    {
        $GLOBALS['loader']->loadClass('Contener_Domain_ThemeTable');
        $this->domain = Doctrine_Core::getTable('Contener_Domain_Theme');
    }
    
    function renderHtml()
    {
        $theme = Contener_Domain_Theme::fetch($this->query('name', null));
        
        $config = include $this->config('loader.base_dir') . '/application/themes/' . $theme->name . '/theme.php';
        
        $valid = true;
        
        $slots = new Contener_Slot_Manager_Basic(array('name' => 'theme'));
        foreach ($config['slots'] as $name => $slot) {
            $slot->setName($name);
            $slots->addSlot($slot);
        }
        
        $array = $theme->toArray();
        $slots->setSlots($array['Slots'][0]['__children'])->manage();
        $theme->setSlotManager($slots);
        
        return Contener_View::create('config/theme/select')->render($this, array('selected' => $theme, 'list' => $this->domain->listThemes($this->query('name', null), $this->config('loader.base_dir'))));
    }
    
    function renderHtmlActivate()
    {
        Doctrine_Query::create()
            ->update('Contener_Domain_Theme t')
            ->set('t.is_active', '?', false)
            ->where('t.is_active = ?', true)
            ->execute();
        
        Doctrine_Query::create()
            ->update('Contener_Domain_Theme t')
            ->set('t.is_active', '?', true)
            ->where('t.name = ?', $this->query('name'))
            ->execute();
        
        return new k_SeeOther(str_replace('activate', 'select', $this->requestUri()));
    }
    
    function renderHtmlEdit()
    {
        $theme = Contener_Domain_Theme::fetch($this->query('name', null));
        $config = include $theme->file_path . '/theme.php';
        
        return Contener_View::create('config/theme/edit')
            ->render($this, array(
                'selected' => $theme,
                'list' => $this->domain->listThemes($this->query('name', null), $this->config('loader.base_dir'))
            ));
    }
    
    function postForm()
    {
        $theme = Contener_Domain_Theme::fetch($this->query('name', null));
        $config = include $this->config('loader.base_dir') . '/themes/' . $theme->name . '/theme.php';
        
        $valid = true;
        
        $slots = new Contener_Slot_Manager_Basic(array('name' => 'theme'));
        foreach ($config['slots'] as $name => $slot) {
            $slot->setName($name);
            $slots->addSlot($slot);
            
            $valid = $slot->isValid($_POST['theme'][$name]) && $valid;
        }
        
        $theme->setSlotManager($slots);
        
        if ($valid) {
            $theme->save();
        }
        
        return $this->renderHtml();
    }
}
