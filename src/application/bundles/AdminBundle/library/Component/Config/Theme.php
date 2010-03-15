<?php

class AdminBundle_Component_Config_Theme extends Contener_Component
{
    protected function listThemes($active = null)
    {
        $themes = array();
        $themesDirectory = $this->config('loader.base_dir') . '/themes';
        $themesIterator = new DirectoryIterator($themesDirectory);
        
        foreach ($themesIterator as $theme) {
            if ($theme->isDot() || !$theme->isDir()) { continue; }
            if (!file_exists($themeFile = $theme->getPathname() . '/theme.php')) { continue; }
            
            $themeConfig = include $themeFile;
            $themeConfig['is_active'] = false;
            
            $slots = new Contener_Slot_Container(array('name' => 'slots'));
            
            foreach($themeConfig['slots'] as $slotName => $slotObject) {
                $slotObject->setName($slotName);
                $slots->addSlot($slotObject);
            }
            
            $themeConfig['slots'] = $slots;
            
            
            $themes[$theme->getFilename()] = $themeConfig;
        }
        
        if ($active) {
            $themes[$active]['is_active'] = true;
        }
        
        return $themes;
    }
    
    function renderHtml()
    {
        return Contener_View::create('config/theme/select')->render($this, array('themes' => $this->listThemes('default')));
    }
    
    function renderHtmlSelect()
    {
        return Contener_View::create('config/theme/select')->render($this, array('themes' => $this->listThemes($this->query('name'))));
    }
    
    function renderHtmlEdit()
    {
        $navigation = new Contener_Navigation(array(
            array('path' => '&file=xxx', 'title' => 'Jakiś plik'),
            array('path' => '&file=xxx', 'title' => 'Jakiś plik'),
            array('path' => '&file=xxx', 'title' => 'Jakiś plik'),
            array('path' => '&file=xxx', 'title' => 'Jakiś plik')
        ));
        
        $this->context->context->area('left')->addModule('Lista szablonów', $navigation);
        
        return 'ustawienia edytora';
    }
}
