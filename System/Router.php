<?php

namespace System;

class Router {
    
    private $routes;
    
    public function __construct() 
    {
           $routerPath = _DIR_ . '/config/routes.php';
           $this->routes = include($routerPath);

    }
    
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        
    }

    public function run() 
    {
        $uri = $this->getURI();
        
        foreach ($this->routes as $uriParameter => $path){
            if (preg_match("~$uriParameter~", $uri)){
                $route = explode('/', $path);
                $controllerName = ucfirst(array_shift($route));
                $methodName = array_shift($route);
                $controllerObject = new $controllerName;
                $result = call_user_func($controllerObject, $methodName());
                if ($result != null) {
                    break;
                } 
            }
        }
    }
}
