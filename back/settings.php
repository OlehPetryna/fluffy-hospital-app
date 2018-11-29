<?php
declare(strict_types=1);

use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

return [
    'settings' => [
        'displayErrorDetails' => getenv('PROD') ? false : true,
        'determineRouteBeforeAppMiddleware' => false,

        'jwtSecret' => getenv('JWT_SECRET'),
        'doctrine' => [
            // if true, metadata caching is forcefully disabled
            'dev_mode' => getenv('PROD') ? false : true,

            // path where the compiled metadata info will be cached
            // make sure the path exists and it is writable
            'cache_dir' => __DIR__. '/var/doctrine',

            // you should add any other path containing annotated entity classes
            'metadata_dirs' => [__DIR__ . '/domain'],

            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => getenv('DB_HOST'),
                'port' => getenv('DB_PORT'),
                'dbname' => getenv('DB_NAME'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'charset' => 'utf8',
                'mapping_types' => ['enum' => 'string'],
            ]
        ]
    ]
];