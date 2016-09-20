<?php
date_default_timezone_set('PRC');
session_start();

// 自动注册类
spl_autoload_register(function ($classname) {
    if(file_exists(__DIR__."/class/{$classname}.php")){
        require_once __DIR__."/class/{$classname}.php";
    }else{
        require_once __DIR__."/class/{$classname}.class.php";
    }
});

function require_file($dir){
    foreach (scandir($dir) as $file){
        if(in_array($file,['.','..'])){
            continue;
        }
        if(file_exists($dir.$file)){
            if(is_dir($dir.$file)){
                require_file($dir.$file);
                continue;
            }else{
                require_once $dir.$file;
            }
        }
    }
}

require_file(__DIR__.'/function/');

$settings = require __DIR__ . '/settings.php';
$app = new \Slim\App($settings);  // 实例化APP

$container = $app->getContainer();

require_once __DIR__ . '/dependencies.php'; // 加载依赖
require_once __DIR__ . '/middleware.php'; // 加载中间件
require_once __DIR__ . '/routes.php'; // 加载路由

$app->run(); // 执行APP