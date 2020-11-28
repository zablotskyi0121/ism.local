<?php

define('_DIR_PUB_', getcwd());
define('_DIR_', str_replace('/pub', '/', _DIR_PUB_));

function appAutoload($class){
    $file = _DIR_ . str_replace("\\", "/", $class) . '.php';

    if (is_readable($file)){
        require_once ($file);
    }
}

spl_autoload_register('appAutoload');

ini_set('display_errors', 1);
error_reporting(E_ALL);
