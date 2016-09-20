<?php

namespace Common\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Controller
{
    protected $request;
    protected $response;
    protected $args;
    protected $headers;
    protected $ci;
    protected $logger;
    protected $view;
    protected $db;
    //Constructor
    public function __construct(ContainerInterface $ci) {
        $this->ci = $ci;
        $this->logger = $ci->get('logger');
        $this->view = $ci->get('view');
        $this->db = $ci->get('db');
    }

    public function __invoke(Request $request, Response $response, array $args) {
        //your code
        //to access items in the container... $this->ci->get('');
        $this->initController($request, $response, $args);
    }

    public function __call($name, $arguments)
    {
        $this->logger->info("__call : name => {$name}, arguments => ".json_encode($arguments));
        $this->__invoke($arguments[0], $arguments[1], $arguments[2]);
    }

    // 初始化
    protected function initController(Request $request, Response $response, array $args){
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        $this->headers = $request->getHeaders();
    }

    // 输出指定内容
    protected function show($content, $contentType='text/html'){
        $body = $this->response->getBody();
        $body->write($content);
        $newResponse = $this->response->withHeader('Content-type', $contentType);
        return $newResponse;
    }

    // 渲染指定模板
    protected function display($tpl,$view){
        if($this->request->isXhr()){
            if($this->headers['HTTP_X_PJAX']){
                return $this->view->render($this->response, "/pjax/{$tpl}", $view);
            }

            $json = $this->response->withResponse($view, 201);
            return $json;
        }

        return $this->view->render($this->response, $tpl, $view);
    }
}