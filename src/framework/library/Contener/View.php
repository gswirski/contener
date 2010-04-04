<?php

class Contener_View extends sfTemplateEngine
{
    protected $baseUrl;
    protected $container;
    
    public function getContainer()
    {
        return $this->container;
    }
    
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }
    
    public function getWidget($class)
    {
        $widget = new $class;
        $widget->setView($this);
        return $widget;
    }
    
    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;
        return $this;
    }
    
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    
    public function installStylesheet($name, $path)
    {
        return $this->installAsset($name, $path, 'style');
    }
    
    public function uninstallStylesheet($name)
    {
        return $this->uninstallAsset($name, 'style');
    }
    
    public function installJavascript($name, $path)
    {
        return $this->installAsset($name, $path, 'script');
    }
    
    public function uninstallJavascript($name)
    {
        return $this->uninstallAsset($name, 'script');
    }
    
    public function installAsset($name, $path, $namespace = '')
    {
        $destination = $this->getContainer()->getParameter('loader.base_dir').'/web/'.$namespace.'s/'.$name;
        copy_directory($path, $destination);
    }
    
    public function uninstallAsset($name, $namespace = '')
    {
    }
}

function copy_directory( $source, $destination ) {
    if ( is_dir( $source ) ) {
        @mkdir( $destination );
        $directory = dir( $source );
        while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
            if ( $readdirectory == '.' || $readdirectory == '..' ) {
                continue;
            }
            $PathDir = $source . '/' . $readdirectory; 
            if ( is_dir( $PathDir ) ) {
                copy_directory( $PathDir, $destination . '/' . $readdirectory );
                continue;
            }
            copy( $PathDir, $destination . '/' . $readdirectory );
        }
        
        $directory->close();
    }else {
        copy( $source, $destination );
    }
}

