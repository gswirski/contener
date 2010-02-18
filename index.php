<?php
//require_once dirname(__FILE__) . '/config/global.inc.php';

function microtime_float()
{
    list($utime, $time) = explode(" ", microtime());
    return ((float)$utime + (float)$time);
}

$script_start = microtime_float();

set_include_path(dirname(__FILE__) . '/lib');
require_once('autoloader.php');
require_once('Konstrukt/konstrukt.inc.php');

$config = include('application/config.php');
$baseUrl = preg_replace('~(.*)/.*~', '$1', $_SERVER['SCRIPT_NAME']);

$conn = Doctrine_Manager::connection($config['database']['dsn']);
Doctrine_Manager::getInstance()->registerHydrator('Contener_Database_Hydrator', 'Contener_Database_Hydrator');


k()
  // Enable file logging
  ->setLog(dirname(__FILE__) . '/application/log/debug.log')
  // Uncomment the next line to enable in-browser debugging
  //->setDebug()
  // Dispatch request
  ->run('Contener_Dispatcher')
  ->out();

$script_end = microtime_float();
echo "Script executed in ".bcsub($script_end, $script_start, 4)." seconds.";