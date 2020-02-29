<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
     */

    'fetch'       => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
     */

    'default'     => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
     */

    'connections' => [

        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => storage_path('database.sqlite'),
            'prefix'   => '',
        ],
        // 主业务库
        'mysql'  => [
            'driver'    => 'mysql',
            'write'     => [
                [
                    'host'     => env('AVATAR_DB_WRITE_HOST', '127.0.0.1'),
                    'username' => env('AVATAR_DB_WRITE_USERNAME', 'root'),
                    'password' => env('AVATAR_DB_WRITE_PASSWORD', ''),
                ],
            ],
            'read'      => [
                [
                    'host'     => env('AVATAR_DB_READ_HOST', '127.0.0.1'),
                    'username' => env('AVATAR_DB_READ_USERNAME', 'root'),
                    'password' => env('AVATAR_DB_READ_PASSWORD', ''),
                ],
            ],
            'port'      => env('DB_PORT', 3306),
            'database'  => env('AVATAR_DB_READ_DATABASE', 'yth_blog'),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'strict'    => false,
        ],
        // - 日志库
        'yth_blog_ext'  => [
            'driver'    => 'mysql',
            'write'     => [
                [
                    'host'     => env('EXT_DB_WRITE_HOST', '127.0.0.1'),
                    'username' => env('EXT_DB_WRITE_USERNAME', 'root'),
                    'password' => env('EXT_DB_WRITE_PASSWORD', ''),
                ],
            ],
            'read'      => [
                [
                    'host'     => env('EXT_DB_READ_HOST', '127.0.0.1'),
                    'username' => env('EXT_DB_READ_USERNAME', 'root'),
                    'password' => env('EXT_DB_READ_PASSWORD', ''),
                ],
            ],
            'port'      => env('DB_PORT', 3306),
            'database'  => env('EXT_DB_READ_DATABASE', 'yth_blog'),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'strict'    => false,
        ],



    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
     */

    'migrations'  => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
     */

    'redis'       => [

        'cluster' => false,

        'default' => [
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'port'     => env('REDIS_PORT', 6379),
            'password' => env('REDIS_PASSWORD', null),
            'database' => env('REDIS_DATABASE', 0),
        ],
        // for lock
        'lock'    => [
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port'     => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DATABASE_LOCK', 1),
        ],

    ],

];
