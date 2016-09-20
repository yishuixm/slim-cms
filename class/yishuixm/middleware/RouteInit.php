<?php

namespace yishuixm\middleware;

use Admin\Model\Config;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class RouteInit
{
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    /**
     *
     *
     * @param  \Psr\Http\Message\RequestInterface  $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface $response PSR7 response
     * @param  callable                            $next     Next middleware
     * @return \Psr\Http\Message\ResponseInterface
     **/
    public function __invoke(Request $request, Response $response, callable $next)
    {

        $Config = new Config($this->ci->get('db'), 'config', true);

        $configs = $Config->select([],["app","name","value"]);
        foreach ($configs['result'] as $config){
            $config_list["{$config['app']}.{$config['name']}"] = $config['value'];
        }
        var_dump($config_list);




        $config = $this->ci->get('config');
        $session = $this->ci->get('session');
        $router = $this->ci->get('router');
        $uri = $request->getUri();
        $path = $uri->getPath();

        $purview = $config->get('purview');

        $no_login = true;


        foreach ($purview['no-login'] as $nl_url){
            if(preg_match($nl_url['match'], $path)){
                $no_login = false;
                $login_url = $router->pathFor($nl_url['login'], [], []);
                break;
            }
        }

        if(!$no_login){
            return $response->withRedirect($login_url,303);
        }


        return $next($request, $response);
    }
}