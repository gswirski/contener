<?php

class WysiwygBundle_Bundle extends Contener_Bundle
{
    public function install()
    {
        $this->container->view->registerJavascript('ckeditor', dirname(__FILE__) . '/Resources/javascripts/ckeditor');
    }
    
    public function init()
    {
        //$this->container->view->addJavascript('ckeditor');
    }
    
    public function uninstall()
    {
        $this->container->view->unregisterJavascript('ckeditor');
    }
}