<?php
use Psr\Http\Message\ResponseInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
$app->post('/common/sms-{mobile:\d+}', function(Request $request, Response $response, array $args){

})->setName("common-sms");