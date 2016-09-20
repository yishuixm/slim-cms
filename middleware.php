<?php
// routes...
$app->add(new yishuixm\middleware\RouteInit($container));
$app->add(new \Slim\Csrf\Guard);
$app->add(new RKA\Middleware\IpAddress(true, []));

