<?php

class Contener_Dispatcher extends Contener_Component {
    function renderHtml()
    {
        return 'Strona użytkownika';
    }
    
    function map($name)
    {
        if ($name == 'admin') {
            return 'AdminBundle_Context';
        }
        
        return 'WebBundle_Context';
    }
}
