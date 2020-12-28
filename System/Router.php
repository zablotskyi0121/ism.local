<?php

namespace System;

class Router {

    const CONTROLLER_PATH = '\\Controller\\';

    public function run() {

        $controllerName = 'Home';
        $modelName = 'Home';
        $action = 'actionHome';
        $errorController = 'Error404';

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
            $controllerPath = self::CONTROLLER_PATH . $errorController;
            $action = \Controller\Error404::page404();
        }
        $controller = new $controllerPath();

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            
        }
    }

}
