<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/runtime/logs/'.date('ymd').'.log',
            'level' => \Monolog\Logger::DEBUG,
        ],


        // twig settings
        'twig' => [
            'path' => __DIR__ . '/templates/',
//            'cache' => __DIR__ . '/runtime/tpl/',
            'cache' => false,
        ],

        // config settings
        'config' => [
            'config' => __DIR__ . '/config',
        ],

        // medoo settings
        'medoo' => [
            'database_type' => 'mysql',
            'database_name' => 'slimcms',
            'server' => 'localhost',
            'username' => 'root',
            'password' => '1983wd75655',
            'charset' => 'utf8',
            'prefix' => 'cms_',
        ],

    ],
];