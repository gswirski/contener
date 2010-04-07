<?php

class CoreBundle_Bundle extends Contener_Bundle
{
    public function install()
    {
        $this->container->view->installStylesheet(
            'reset.css', dirname(__FILE__) . '/Resources/reset.css'
        );
    }
    
    public function uninstall()
    {
        $this->container->view->uninstallStylesheet('reset.css');
    }
}