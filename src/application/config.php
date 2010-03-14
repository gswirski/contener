<?php

$config = array();

$config['loader'] = array(
    'base_dir' => '/Users/sognat/Sites/Kontener/src'
);

$config['database'] = array(
    'dsn'                 =>  'sqlite:' . $config['loader']['base_dir'] . '/application/database/database.db',
    'data_fixtures_path'  =>  'application/database/fixtures',
    'models_path'         =>  'framework',
    'yaml_schema_path'    =>  'application/database/schema',
    'generate_models_options' => array(
        'baseClassPrefix'     => 'Base_',
        'classPrefix' => 'Contener_Domain_',
        'baseClassesDirectory' => '',
        'pearStyle' => true
    )
);

return $config;
