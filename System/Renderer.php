<?php

namespace System;

class Renderer {

    public static function render($pageTemplate, $params = array(), $isAdmin = false) {
        extract($params);
        require_once $isAdmin ? _DIR_ . '/Layout/Admin.php' : _DIR_ . '/Layout/Default.php';
    }
    
    public static function renderEmail($pageTemplate, $params = array()) {
        extract($params);
        require_once _DIR_ . '/Layout/Email.php';
    }

}
