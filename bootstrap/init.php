<?php

define('_DIR_PUB_', getcwd());
define('_DIR_', realpath('../') . DIRECTORY_SEPARATOR);

function appAutoload($class) {
    $file = _DIR_ . str_replace("\\", "/", $class) . '.php';

    if (is_readable($file)) {
        require_once ($file);
    }
}

spl_autoload_register('appAutoload');

function ErrorHandler($errno, $errmsg, $errfile, $errline) {
    $controller = new \Controller\Error503();
    $controller->page503();
    error_log($errfile, $errline, $errmsg);
    die();
    return true;
}

function fatalErrorHandler() {
    if (!empty($error = error_get_last() AND $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR))) {
        ob_get_clean();
        $controller = new \Controller\Error503();
        $controller->page503();
    }
}

set_error_handler('ErrorHandler');
register_shutdown_function('fatalErrorHandler');

ini_set('display_errors', 1);
error_reporting(E_ALL);
