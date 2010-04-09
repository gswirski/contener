<?php

class AdminBundle_Bundle extends Contener_Bundle
{
    public function install()
    {
        $this->container->view->installJavascript(
            'admin/script.js', dirname(__FILE__) . '/Resources/script.js'
        );
        
        $this->container->view->installStylesheet(
            'admin/style.css', dirname(__FILE__) . '/Resources/style.css'
        );
    }
    
    public function init()
    {
        $this->container->view->javascripts->add('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
        $this->container->view->javascripts->add('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js');
        $this->container->view->javascripts->add('scripts/lightbox/jquery.lightbox.js');
        $this->container->view->javascripts->add('scripts/admin/script.js');
        
        $this->container->view->stylesheets->add('styles/admin/style.css');
        $this->container->view->stylesheets->add('scripts/lightbox/jquery.lightbox.css');
    }
    
    public function uninstall()
    {
        $this->container->view->uninstallJavascript('admin/script.js');
        $this->container->view->uninstallStylesheet('admin/style.css');
    }
}