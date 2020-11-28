<?php

namespace System;

class Db{

public static function connTODB() {
    
    $username = \System\ConfigManager::getConfig('db\username');
    $password = \System\ConfigManager::getConfig('db\password');
    $server = \System\ConfigManager::getConfig('db\host');
    $dbname = \System\ConfigManager::getConfig('db\dbName');

    $db_connection = new \PDO("mysql:dbname=$dbname;host=$server", $username, $password);
    
    return $db_connection; 
   
    }

}