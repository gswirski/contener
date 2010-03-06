<?php

class Application
{   
    public function initLoader(Contener_Loader $loader)
    {
        $loader->registerBundle('WebBundle', 'application/bundles/WebBundle')
               ->registerBundle('AdminBundle', 'application/bundles/AdminBundle');
    }
    
    public function initDatabase()
    {
        $config = include('config.php');
        
        Doctrine_Manager::connection($config['database']['dsn']);
        Doctrine_Manager::getInstance()->registerHydrator('Contener_Database_Hydrator', 'Contener_Database_Hydrator');
    }
    
    public static function run()
    {
        set_include_path('../framework');
        
        $GLOBALS['baseUrl'] = preg_replace('~(.*)/.*~', '$1', $_SERVER['SCRIPT_NAME']);
        
        $app = new self;
        
        require_once('../framework/Contener/Loader.php');
        $loader = new Contener_Loader();
        $app->initLoader($loader);
        spl_autoload_register(array($loader, 'loadClass'));
        
        require_once('../framework/Konstrukt/konstrukt.inc.php');
        
        $app->initDatabase();
        
        k()
          ->setLog(dirname(__FILE__) . '/log/debug.log')
          ->run('Contener_Dispatcher')
          ->out();
    }
}
