<?php

namespace System;

use Controller\Home;

class Router {

    const CONTROLLER_PATH = '\\Controller\\';

    public function run() {

        $controllerName = 'Home';
        $modelName = 'Home';
        $action = 'actionHome';
        
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($routes[1])) {
            $controllerName = ucfirst($routes[1]);
        }
        if (!empty($routes[2])) {
            $action = 'action' . ucfirst($routes[2]);
        }
        $controllerPath = self::CONTROLLER_PATH . $controllerName;
        $controller = new $controllerPath();
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Route::ErrorPage404();
        }
    }

    function ErrorPage404() {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }

}
