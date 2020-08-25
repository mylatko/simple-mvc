<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
//        'production' => [
//            'adapter' => 'mysql',
//            'host' => '127.0.0.1:3333',
//            'name' => 'production_db',
//            'user' => 'root',
//            'pass' => '',
//            'port' => '3306',
//            'charset' => 'utf8',
//        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => getenv('MYSQL_HOST'),
            'name' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USER'),
            'pass' => getenv('MYSQL_PASSWORD'),
            'port' => getenv('MYSQL_PORT'),
            'charset' => 'utf8',
        ],
//        'testing' => [
//            'adapter' => 'mysql',
//            'host' => '127.0.0.1:3333',
//            'name' => 'testing_db',
//            'user' => 'root',
//            'pass' => '',
//            'port' => '3306',
//            'charset' => 'utf8',
//        ]
    ],
    'version_order' => 'creation'
];
