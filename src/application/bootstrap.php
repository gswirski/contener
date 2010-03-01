<?php

class Application
{   
    public function initLoader(Contener_Loader $loader)
    {
        $loader->registerBundle('WebBundle', '../application/bundles/WebBundle')
               ->registerBundle('AdminBundle', '../application/bundles/AdminBundle');
    }
    
    public function initDatabase()
    {
        $config = include('config.php');
        
        Doctrine_Manager::connection($config['database']['dsn']);
        Doctrine_Manager::getInstance()->registerHydrator('Contener_Database_Hydrator', 'Contener_Database_Hydrator');
    }
    
    public static function run()
    {
        $GLOBALS['baseUrl'] = preg_replace('~(.*)/.*~', '$1', $_SERVER['SCRIPT_NAME']);
        
        $app = new self;
        
        set_include_path(dirname(__FILE__) . '/../framework');
        
        require_once('Contener/Loader.php');
        $loader = new Contener_Loader();
        $app->initLoader($loader);
        spl_autoload_register(array($loader, 'loadClass'));
        
        require_once('Konstrukt/konstrukt.inc.php');
        
        $app->initDatabase();
        
        k()
          ->setLog(dirname(__FILE__) . '/log/debug.log')
          ->run('Contener_Dispatcher')
          ->out();
    }
}
