<?php

return [
    'db' => [
        'host' => $_ENV['MYSQL_HOST'],
        'dbname' => $_ENV['MYSQL_DATABASE'],
        'user' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
        'port' => $_ENV['MYSQL_PORT']
    ]
];
