<?php

class CoreBundle_Bundle extends Contener_Bundle
{
    public function install()
    {
        $this->container->view->installAssets(array(
            'styles/reset.css' => dirname(__FILE__) . '/Resources/reset.css',
            'lightbox' => dirname(__FILE__) . '/Resources/lightbox'
        ));
    }
    
    public function uninstall()
    {
        $this->container->view->uninstallStylesheet('reset.css');
        $this->container->view->uninstallJavascript('lightbox');
    }
}