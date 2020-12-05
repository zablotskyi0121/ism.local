<?php

namespace System;

class Db{
    
    private static $object;
    private $db_connection;
    
    private function __construct() {
        $username = \System\ConfigManager::getConfig('db\username');
        $password = \System\ConfigManager::getConfig('db\password');
        $server = \System\ConfigManager::getConfig('db\host');
        $dbname = \System\ConfigManager::getConfig('db\dbName');

        $db_connection = new \PDO("mysql:dbname=$dbname;host=$server", $username, $password);
    
        $this->db_connection = $db_connection; 
    }
    
    public static function getInstance() {
        
        if (static::$object == null) {
        static::$object = new static();
        }
        return static::$object;
        
    }
    
    public function getDbConnection() {
        return $this->db_connection;
    }

  }