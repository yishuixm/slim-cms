<?php
$app->get('/admin/login', 'Admin\Controller\PublicController:login')->setName("admin-login");
$app->get('/admin', 'Admin\Controller\PublicController:home')->setName("admin-home");



