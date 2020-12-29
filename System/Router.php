<?php

namespace System;

class Router {

    const CONTROLLER_PATH = '\\Controller\\';

    public function run() {

        $controllerName = 'Home';
        $modelName = 'Home';
        $action = 'actionHome';
        $error404Controller = 'Error404';
        $error503Controller = 'Error503';


        if (http_response_code() == 503) {
            $controllerPath = self::CONTROLLER_PATH . $error503Controller;
            $action = \Controller\Error503::page503();
        }

        $routes = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($routes[1])) {
            $controllerName = ucfirst($routes[1]);
        }
        if (!empty($routes[2])) {
            $action = 'action' . ucfirst($routes[2]);
        }
        $controllerPath = self::CONTROLLER_PATH . $controllerName;

        if (class_exists($controllerPath)) {
            $controllerPath = self::CONTROLLER_PATH . $controllerName;
        } else {
            $controllerPath = self::CONTROLLER_PATH . $error404Controller;
            $action = \Controller\Error404::page404();
        }
        $controller = new $controllerPath();

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            
        }
    }

}
