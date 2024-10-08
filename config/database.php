<?php

return [

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

    'default' => env('DB_CONNECTION', 'mysql'),

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
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

        'LGIGlobal' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_LGIGlobal', 'localhost'),
            'port' => env('DB_PORT_LGIGlobal', '1433'),
            'database' => env('DB_DATABASE_LGIGlobal', 'forge'),
            'username' => env('DB_USERNAME_LGIGlobal', 'forge'),
            'password' => env('DB_PASSWORD_LGIGlobal', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'pooling' => env('APP_POOLING_DB', false)
        ],

        'ReportGenerator181' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_REPORT_GENERATOR_181', 'localhost'),
            'port' => env('DB_PORT_REPORT_GENERATOR_181', '1433'),
            'database' => env('DB_DATABASE_REPORT_GENERATOR_181', 'forge'),
            'username' => env('DB_USERNAME_REPORT_GENERATOR_181', 'forge'),
            'password' => env('DB_PASSWORD_REPORT_GENERATOR_181', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'pooling' => env('APP_POOLING_DB', false)
        ],

        'SeaReport181' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_SEA_REPORT_181', 'localhost'),
            'port' => env('DB_PORT_SEA_REPORT_181', '1433'),
            'database' => env('DB_DATABASE_SEA_REPORT_181', 'forge'),
            'username' => env('DB_USERNAME_SEA_REPORT_181', 'forge'),
            'password' => env('DB_PASSWORD_SEA_REPORT_181', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'pooling' => env('APP_POOLING_DB', false)
        ],

        'EPO114' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_EPO_114', 'localhost'),
            'port' => env('DB_PORT_EPO_114', '1433'),
            'database' => env('DB_DATABASE_EPO_114', 'forge'),
            'username' => env('DB_USERNAME_EPO_114', 'forge'),
            'password' => env('DB_PASSWORD_EPO_114', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'pooling' => env('APP_POOLING_DB', false)
        ],

        'ISSURANCE_LIVE' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_ISSURANCE_LIVE', 'localhost'),
            'port' => env('DB_PORT_ISSURANCE_LIVE', '1433'),
            'database' => env('DB_DATABASE_ISSURANCE_LIVE', 'forge'),
            'username' => env('DB_USERNAME_ISSURANCE_LIVE', 'forge'),
            'password' => env('DB_PASSWORD_ISSURANCE_LIVE', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'pooling' => env('APP_POOLING_DB', false)
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

    'migrations' => 'migrations',

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

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
