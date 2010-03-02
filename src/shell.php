<?php

set_include_path(dirname(__FILE__) . '/framework');

require_once 'Konstrukt/konstrukt.inc.php';
require_once 'Contener/Loader.php';
$loader = new Contener_Loader();
spl_autoload_register(array($loader, 'loadClass'));

$config = include 'application/config.php';

$conn = Doctrine_Manager::connection($config['database']['dsn']);
$cli = new Doctrine_Cli($config['database']);
$cli->run($_SERVER['argv']);
