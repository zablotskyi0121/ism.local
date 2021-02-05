<?php

session_start();
require_once '../bootstrap/init.php';

$router = new \System\Router();
$router->run();
