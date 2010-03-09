<?php

class AdminBundle_Component_Config_Theme extends Contener_Component
{
    function renderHtml()
    {
        return Contener_View::create('config/theme/select')->render($this);
    }
    
    function renderHtmlSelect()
    {
        return Contener_View::create('config/theme/select')->render($this);
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
