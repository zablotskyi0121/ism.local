<?php

namespace System;

class Db {

    private static $_instance = null;

    private function __construct() {
        $username = \System\ConfigManager::getConfig('db\username');
        $password = \System\ConfigManager::getConfig('db\password');
        $server = \System\ConfigManager::getConfig('db\host');
        $dbname = \System\ConfigManager::getConfig('db\dbName');

        try {
            self::$_instance = new \PDO("mysql:dbname=$dbname;host=$server", $username, $password);
        } catch (\PDOException $ex) {
            $controller = new \Controller\Error503();
            $controller->page503();
            error_log($ex);
            die();
        }
    }

    public static function getInstance() {

        if (self::$_instance != null) {
            return self::$_instance;
        }

        return new self;
    }

}
