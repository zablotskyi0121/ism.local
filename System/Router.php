<?php

namespace System;

class Router {

    const CONTROLLER_PATH = '\\Controller\\';

    public function run() {

        $controllerName = 'Home';
        $modelName = 'Home';
        $action = 'actionHome';
        $error404Controller = 'Error404';

        $routesWithParameter = explode('?', $_SERVER['REQUEST_URI']);
        $routesWithParameter = $routesWithParameter[0];
        $routes = explode('/', $routesWithParameter);
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
        try {
            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                throw new \Exception('Router');
            }
        } catch (\Exception $e) {
            $controller = new \Controller\Error503();
            $controller->page503();
            error_log($e);
            die();
        }
    }

}
