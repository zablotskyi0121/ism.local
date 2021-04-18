<?php

namespace System;


class App {

    public static function getModel($modelName) {
        
        return new $modelName();
        // To do: check if class exist -> exception if class not found
    }
    
    public static function getUserId() {
        $sessionId = session_id();
        $userId = \Model\User::getUserId($sessionId);
        return $userId;
    }
    }
