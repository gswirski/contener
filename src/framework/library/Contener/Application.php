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
        $container = $this->getContainer();
        $container->setParameter('request.base_url', preg_replace('~(.*)/.*~', '$1', $_SERVER['SCRIPT_NAME']));
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