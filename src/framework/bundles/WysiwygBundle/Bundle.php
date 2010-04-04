<?php

class WysiwygBundle_Bundle extends Contener_Bundle
{
    public function install()
    {
        $this->container->view->installJavascript(
            'ckeditor', dirname(__FILE__) . '/Resources/javascripts/ckeditor'
        );
    }
    
    public function init()
    {
        $this->container->view->javascripts->add('scripts/ckeditor/ckeditor.js');
        $this->container->view->javascripts->add('scripts/ckeditor/adapters/jquery.js');
        $this->container->view->javascripts->add('scripts/ckeditor/activator.js');
    }
    
    public function uninstall()
    {
        $this->container->view->uninstallJavascript('ckeditor');
    }
}