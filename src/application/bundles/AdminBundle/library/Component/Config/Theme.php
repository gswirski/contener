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
        return Contener_View::create('config/theme/select')->render($this, array('themes' => $this->domain->listThemes('default', $this->config('loader.base_dir'))));
    }
    
    function renderHtmlSelect()
    {
        return Contener_View::create('config/theme/select')->render($this, array('themes' => $this->domain->listThemes($this->query('name'), $this->config('loader.base_dir'))));
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
    
    function postForm()
    {
        print_r($_POST);
    }
}
