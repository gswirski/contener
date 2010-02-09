<?php

class Contener_Page extends Contener_Component
{
    protected $record;
    
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->record, $method), $args);
    }
    
    public function map($name)
    {
        return 'Contener_Page';
    }
    
    public function renderHtml()
    {
        return 'works';
    }
}