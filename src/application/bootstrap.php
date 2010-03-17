<?php

require_once dirname(__FILE__) . '/../framework/library/Contener/Application.php';
require_once dirname(__FILE__) . '/../framework/library/Loader.php';

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
        
        $loader->registerNamespace('Contener', 'framework/library/Contener')
               ->registerNamespace('Doctrine', 'framework/library/Doctrine')
               ->registerNamespace('Zend', 'framework/library/Zend');
        
        $loader->registerBundle('WebBundle', 'framework/bundles/WebBundle')
               ->registerBundle('AdminBundle', 'framework/bundles/AdminBundle');
        
        $loader->registerExtension('Contener', array($this, 'loaderExtension'));
        
        $this->loader = $loader;
        $GLOBALS['loader'] = $loader;
        spl_autoload_register(array($this->loader, 'loadClass'));
    }
    
    public function loaderExtension($class, $loader)
    {
        $substr = substr($class, 0, 6);
        
        if ($substr == 'sfYaml') {
            return $loader->loadFile('framework/library/Doctrine/Parser/sfYaml/' . $class . '.php');
        } else if ($substr == 'sfTemp') {
            return $loader->loadFile('framework/library/sfTemplate/'.$class.'.php');
        } else if ($substr == 'sfServ') {
            return $loader->loadFile('framework/library/sfService/'.$class.'.php');
        } else if ($substr == 'sfEven') {
            return $loader->loadFile('framework/library/sfTemplate/'.$class.'.php');
        }
        
        return false;
    }
    
    public function initDatabase()
    {
        $this->connection = Doctrine_Manager::connection($this->config['database']['dsn']);
        Doctrine_Manager::getInstance()->registerHydrator('Contener_Database_Hydrator', 'Contener_Database_Hydrator');
    }
}
