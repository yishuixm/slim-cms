<?php
// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
// medoo
$container['db'] = function ($c) {
    $settings = $c->get('settings')['medoo'];
    return new medoo($settings);
};

// Register Twig View helper
$container['view'] = function ($c) {
    $settings = $c->get('settings')['twig'];

    $view = new \Slim\Views\Twig($settings['path'], [
        'cache' => $settings['cache']
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// Register provider
$container['config'] = function ($c) {
    $settings = $c->get('settings')['config'];
    //Create the configuration
    return new Noodlehaus\Config($settings['config']);
};

// tools
$container['tools'] = function () {
    $tools['String'] = new yishuixm\tools\StringTools;

    return $tools;
};

// session
$container['session'] = function () {
    return @yishuixm\session\Session::getInstance();
};

// csrf
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};