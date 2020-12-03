<?php

require_once '../bootstrap/init.php';

\Controller\Product::getList();

$router = new \System\Router();
$router->run();