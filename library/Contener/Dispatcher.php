<?php

class Contener_Dispatcher extends Contener_Component {
    function renderHtml()
    {
        return 'Strona użytkownika';
    }
    
    function map($name)
    {
        if ($name == 'admin') {
            return 'Contener_Context_Admin';
        }
        
        return 'Contener_Context_Default';
    }
}
