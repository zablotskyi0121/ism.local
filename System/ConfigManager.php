<?php

namespace System;
require_once '../config/config.php';

class ConfigManager {

     public static function getConfig(string $path): ?string
     {
         $config = \Config::getConfig();
         return isset($config[$path]) ? $config[$path] : null;
     }
     
 } 