<?php
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->view->render($response, 'profile.html', [
        'name' => $args['name']
    ]);
})->setName('profile');


$app->get('/adm', 'Admin\Controller\PublicController:home')->setName("admin-home");
$app->get('/login/adm', 'Admin\Controller\PublicController:login')->setName("admin-login");


