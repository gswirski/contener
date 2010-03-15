<?php

require_once dirname(__FILE__) . '/../framework/Contener/Application.php';
require_once dirname(__FILE__) . '/../framework/Loader.php';

class Application extends Contener_Application
{
    public function init()
    {
        $this->config = include 'config.php';
        $GLOBALS['config'] = $this->config;
        $this->initLoader();
        $this->initDatabase();
    }
    
    public function initLoader()
    {
        $loader = new Loader($this->config['loader']);
        
        $loader->registerNamespace('Contener', 'framework/Contener')
               ->registerNamespace('Doctrine', 'framework/Doctrine')
               ->registerNamespace('Zend', 'framework/Zend');
        
        $loader->registerBundle('WebBundle', 'application/bundles/WebBundle')
               ->registerBundle('AdminBundle', 'application/bundles/AdminBundle');
        
        $loader->registerExtension('Contener', array($this, 'loaderExtension'));
        
        $this->loader = $loader;
        
        spl_autoload_register(array($this->loader, 'loadClass'));
    }
    
    public function loaderExtension($class, $loader)
    {
        if (substr($class, 0, 6) == 'sfYaml') {
            return $loader->loadFile('framework/Doctrine/Parser/sfYaml/' . $class . '.php');
        } else if (substr($class, 0, 10) == 'sfTemplate') {
            return $loader->loadFile('framework/Templating/'.$class.'.php');
        }
        
        return false;
    }
    
    public function initDatabase()
    {
        $this->connection = Doctrine_Manager::connection($this->config['database']['dsn']);
        Doctrine_Manager::getInstance()->registerHydrator('Contener_Database_Hydrator', 'Contener_Database_Hydrator');
    }
}
