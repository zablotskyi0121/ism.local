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

ini_set('display_errors', 1);
error_reporting(E_ALL);
