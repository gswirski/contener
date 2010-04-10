<?php

require_once dirname(__FILE__) . '/../Konstrukt/konstrukt.inc.php';

class Contener_Application
{
    protected $config = array();
    public $loader;
    public $connection;
    protected $container;
    
    public function __construct($env) {
        set_include_path(dirname(__FILE__) . '/..');
        $this->init();
    }
    
    public function init() {}
    
    public function run()
    {
        Contener_Application_Data::setBaseDir($this->config['loader.base_dir']);
        
        $cache = new Contener_Application_Data('cache/service.php');
        
        if ($cache->exists()) {
            require_once $cache->getPath();
            $container = $this->getContainer(true);
            
            $this->_run($container);
        } else {
            $container = $this->getContainer(false);
            
            $this->_run($container);
            
            $dumper = new sfServiceContainerDumperPhp($container);
            $cache->write($dumper->dump(array(
                'class' => 'Application_Cache_ServiceContainer', 
                'base_class' => 'Contener_ServiceContainer'
            )));
        }
    }
    
    protected function _run($container)
    {
        $container->setParameter(
            'request.base_url', 
            preg_replace('~(.*)/.*~', '$1', $_SERVER['SCRIPT_NAME'])
        );
        
        $loader = $container->getService('loader')->handleBundles($container);
        
        $creator = $container->getService('component.creator');
        
        k()
          ->setDebug(false)
          ->setComponentCreator($creator)
          ->run('Contener_Dispatcher')
          ->out();
    }
    
    public function setConfig($config)
    {
        $this->config = $config;
    }
    
    protected function getContainer($fromCache = false)
    {
        if (!$this->container) {
            if ($fromCache) {
                $this->container = new Application_Cache_ServiceContainer;
            } else {
                $this->container = new Contener_ServiceContainer($this->config);
                $loader = new sfServiceContainerLoaderFileXml($this->container);
                $loader->load(dirname(__FILE__) . '/Resources/services.xml');
            }
        }
        
        return $this->container;
    }
}