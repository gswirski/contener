<?php

class CoreBundle_Bundle extends Contener_Bundle
{
    public function install()
    {
        $this->container->view->installStylesheet(
            'reset.css', dirname(__FILE__) . '/Resources/reset.css'
        );
        
        $this->container->view->installJavascript(
            'lightbox', dirname(__FILE__) . '/Resources/lightbox'
        );
    }
    
    public function uninstall()
    {
        $this->container->view->uninstallStylesheet('reset.css');
        $this->container->view->uninstallJavascript('lightbox');
    }
}