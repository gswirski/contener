<?php

class AdminBundle_Bundle extends Contener_Bundle
{
    public function install()
    {
        $this->container->view->installAssets('admin', dirname(__FILE__) . '/Resources/public');
    }
    
    public function init()
    {
        $this->container->view->javascripts->add('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
        $this->container->view->javascripts->add('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js');
        $this->container->view->javascripts->add('assets/lightbox/jquery.lightbox.js');
        $this->container->view->javascripts->add('assets/admin/scripts/swfupload/swfupload.js');
        $this->container->view->javascripts->add('assets/admin/scripts/swfupload/swfupload.queue.js');
        $this->container->view->javascripts->add('assets/admin/scripts/fileprogress.js');
        $this->container->view->javascripts->add('assets/admin/scripts/handlers.js');
        $this->container->view->javascripts->add('assets/admin/scripts/script.js');
        
        $this->container->view->stylesheets->add('assets/styles/reset.css');
        $this->container->view->stylesheets->add('assets/admin/styles/style.css');
        $this->container->view->stylesheets->add('assets/lightbox/jquery.lightbox.css');
    }
    
    public function uninstall()
    {
    }
}