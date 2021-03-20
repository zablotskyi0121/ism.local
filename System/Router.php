<?php

namespace System;

class Router {

    const CONTROLLER_PATH = '\\Controller\\';

    public function run() {

        $controllerName = 'Home';
        $modelName = 'Home';
        $action = 'actionHome';
        $parameter = '';
        $error404Controller = 'Error404';

        $routesWithParameter = explode('?', $_SERVER['REQUEST_URI']);
        $routesWithParameter = $routesWithParameter[0];
        $routes = explode('/', $routesWithParameter);

        if (strpos(_URL_, _ADMIN_URL_) !== false) {

            array_shift($routes);
        }

        if (!empty($routes[1])) {
            $controllerName = ucfirst($routes[1]);
        }
        if (!empty($routes[2])) {
            $action = 'action' . ucfirst($routes[2]);
        }
        if (!empty($routes[3])) {
            $parameter = $routes[3];
        }

        $controllerPath = self::CONTROLLER_PATH . $controllerName;

        if (strpos(_URL_, _ADMIN_URL_) !== false) {
            $controllerPath = self::CONTROLLER_PATH . 'Admin\\' . $controllerName;
        } elseif (class_exists($controllerPath)) {
            $controllerPath = self::CONTROLLER_PATH . $controllerName;
        } else {
            $controllerPath = self::CONTROLLER_PATH . $error404Controller;
            $action = \Controller\Error404::page404();
            die();
        }

        $controller = new $controllerPath();
        try {
            if (method_exists($controller, $action)) {
                $controller->$action($parameter);
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
