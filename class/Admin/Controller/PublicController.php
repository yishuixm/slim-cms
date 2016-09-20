<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/15
 * Time: 1:49
 */

namespace Admin\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PublicController extends \Common\Controller\Controller
{
    public function home(Request $request, Response $response, array $args){
        $this->initController($request, $response, $args);


        $this->display('admin/index.twig', []);
    }

    public function login(Request $request, Response $response, array $args){
        $this->initController($request, $response, $args);



        $this->display('admin/login.twig', []);
    }
}