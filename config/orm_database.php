<?php

/*******************   数据库链接信息     *********************/

return [
    'mysql' => [
        'driver' => 'mysql',
        'url' => '',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'your-database-name',
        'username' => 'your-database-username',
        'password' => 'your-database-password',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => false,
        'engine' => null,
        'options' => extension_loaded('pdo_mysql') ? array_filter([
            PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        ]) : [],
    ],
    //TODO：可配置为多链接信息，详情查询ORM配置方法
    'connectoin_two' => [

    ],
];
