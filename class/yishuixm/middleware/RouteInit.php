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

    private function isLogined(){
        $db = $this->ci->get("db");
        $session = $this->ci->get("session");
        $username = $session->username;
        $user_id = $session->user_id;
        $login_info = $session->login_info;

        if(!$login_info){
            return false;
        }

        return $db->has("user", [
            "AND"           => [
                "login_info[=]"     => $login_info,
                "username[=]"       => $username,
                "id[=]"             => $user_id,
            ]
        ]);
    }

    private function isAccessible($path){
        $db = $this->ci->get("db");
        $session = $this->ci->get("session");
        $user_id = $session->user_id;

        $user_accessible = $db->get("user_accessible", "accessible", [
            "uid[=]"            => $user_id
        ]);
        $user_accessible = unserialize($user_accessible);
        $accessible = $db->get("accessible", ["id","login_url"], [
            "path[=]"            => $path
        ]);

        return in_array($accessible['id'], $user_accessible)?:$accessible['login_url'];
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

        $configs = $Config->select("config",["app","name","value"], []);

        foreach ($configs['result'] as $config) {
            $config_list["{$config['app']}.{$config['name']}"] = $config['value'];
        }



        $session = $this->ci->get('session');
        $router = $this->ci->get('router');
        $uri = $request->getUri();
        $path = $uri->getPath();

        if(array_key_exists("COMMON.LOGIN_URL", $config_list)){
            $login_url = unserialize($config_list["COMMON.LOGIN_URL"]);
        }else{
            $login_url = [];
        }

        if(is_array($login_url)){
            foreach ($login_url as $url){
                if(!preg_match("/{$url}/", $path)){
                    continue;
                }
                if(!$this->isLogined()){
                    return $response->withRedirect('/login', 303);
                }
                if(!$this->isAccessible($path)){
                    $response->withRedirect('/pessimists', 303);
                }
            }
        }


        return $next($request, $response);
    }
}