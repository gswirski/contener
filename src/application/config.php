<?php

$config = array();

$config['loader.base_dir']                  = dirname(__FILE__) . '/..';

$config['database.dsn']                     = 'sqlite:' . $config['loader.base_dir'] . '/application/database/database.db';
$config['database.data_fixtures_path']      = 'application/database/fixtures';
$config['database.models_path']             = 'framework/library';
$config['database.yaml_schema_path']        = 'application/database/schema';
$config['database.generate_models_options'] = array(
   'generateTableClasses'                       =>  true, 
   'baseClassPrefix'                            => 'Base_',
   'classPrefix'                                => 'Contener_Database_Model_',
   'baseClassesDirectory'                       => '',
   'pearStyle'                                  => true
);

return $config;
