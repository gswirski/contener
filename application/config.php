<?php

return array(
    'loader'=>array(
        'library_dir'         =>  'library',
        'model_dir'           =>  'application/database/models',
        'model_generated_dir' =>  'application/database/models/generated',
        'context_dir'         =>  'application/context',
        'pages_dir'           =>  'application/pages',
        'plugin_dir'          =>  'plugins',
        'cache_dir'           =>  'application/cache'
    ),
    'database'=>array(
        'dsn'                 =>  'sqlite:application/database/database.db',
        'data_fixtures_path'  =>  'application/database/fixtures',
        'models_path'         =>  'lib',
        'yaml_schema_path'    =>  'application/database/schema',
        'generate_models_options' => array(
            'baseClassPrefix'     => 'Base_',
            'classPrefix' => 'Contener_Domain_',
            'baseClassesDirectory' => '',
            'pearStyle' => true
        )
        
    ),
);
