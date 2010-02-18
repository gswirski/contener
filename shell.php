<?php

set_include_path(dirname(__FILE__) . '/lib');
require_once('autoloader.php');
require_once('Konstrukt/konstrukt.inc.php');

$config = include 'application/config.php';

$conn = Doctrine_Manager::connection($config['database']['dsn']);
$cli = new Doctrine_Cli($config['database']);
$cli->run($_SERVER['argv']);