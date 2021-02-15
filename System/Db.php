<?php

namespace System;

class Db {

    private static $db = null;

    private function __construct() {
        $username = \System\ConfigManager::getConfig('db\username');
        $password = \System\ConfigManager::getConfig('db\password');
        $server = \System\ConfigManager::getConfig('db\host');
        $dbname = \System\ConfigManager::getConfig('db\dbName');

        try {
            self::$db = new \PDO("mysql:dbname=$dbname;host=$server", $username, $password);
        } catch (\PDOException $ex) {
            $controller = new \Controller\Error503();
            $controller->page503();
            error_log($ex);
            die();
        }
    }

    public static function getInstance() {

        if (self::$db != null) {
            return self::$db;
        }

        return new self;
    }

}
