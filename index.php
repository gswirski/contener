<?php
//require_once dirname(__FILE__) . '/config/global.inc.php';

set_include_path(dirname(__FILE__) . '/lib');
require_once('autoloader.php');
require_once('Konstrukt/konstrukt.inc.php');

k()
  // Enable file logging
  ->setLog(dirname(__FILE__) . '/log/debug.log')
  // Uncomment the next line to enable in-browser debugging
  //->setDebug()
  // Dispatch request
  ->run('Contener_Dispatcher')
  ->out();
