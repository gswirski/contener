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
        $cache = $this->config['loader.base_dir'] . '/application/cache/service.php';
        
        if (file_exists($cache)) {
            require_once $cache;
            $container = new Application_Cache_ServiceContainer;
            
            $this->_run($container);
        } else {
            $container = $this->getContainer();
            $container->setParameter(
                'request.base_url', 
                preg_replace('~(.*)/.*~', '$1', $_SERVER['SCRIPT_NAME'])
            );
            
            $this->_run($container);
            
            $dumper = new sfServiceContainerDumperPhp($container);
            file_put_contents($cache, $dumper->dump(array(
                'class' => 'Application_Cache_ServiceContainer', 
                'base_class' => 'Contener_ServiceContainer'
            )));
        }
    }
    
    protected function _run($container)
    {
        $creator = $container->getService('component.creator');
        
        k()
          ->setLog($this->config['loader.base_dir'] . '/application/log/debug.log')
          ->setComponentCreator($creator)
          ->run('Contener_Dispatcher')
          ->out();
    }
    
    public function setConfig($config)
    {
        $this->config = $config;
    }
    
    protected function getContainer()
    {
        if (!$this->container) {
            $this->container = new Contener_ServiceContainer($this->config);
            $loader = new sfServiceContainerLoaderFileXml($this->container);
            $loader->load(dirname(__FILE__) . '/Resources/services.xml');
        }
        
        return $this->container;
    }
}