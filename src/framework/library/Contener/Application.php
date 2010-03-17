<?php

require_once dirname(__FILE__) . '/../Konstrukt/konstrukt.inc.php';

class Contener_Application
{
    public $config = array();
    public $loader;
    public $connection;
    
    public function __construct($env) {
        set_include_path(dirname(__FILE__) . '/..');
        $this->init();
    }
    public function init() {}
    
    public function run()
    {
        $GLOBALS['baseUrl'] = preg_replace('~(.*)/.*~', '$1', $_SERVER['SCRIPT_NAME']);
        
        k()
          ->setLog($this->config['loader']['base_dir'] . '/application/log/debug.log')
          ->run('Contener_Dispatcher')
          ->out();
    }
}