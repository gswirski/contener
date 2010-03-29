<?php

class Contener_View_Helper_Url extends sfTemplateHelper
{
    protected $baseUrl;
    
    public function __construct($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }
    
    public function getName()
    {
        return 'url';
    }
    
    public function build($path)
    {
        return $this->baseUrl . '/' . $path;
    }
}