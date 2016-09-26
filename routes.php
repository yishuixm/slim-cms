<?php
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->view->render($response, 'profile.html', [
        'name' => $args['name']
    ]);
})->setName('profile');

$app->get('/admin/login', 'Admin\Controller\PublicController:login')->setName("login");
$app->get('/admin', 'Admin\Controller\PublicController:home')->setName("admin-home");



