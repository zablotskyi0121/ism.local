<?php

namespace System;

class Renderer {

    public function render($pageLayout, $params = array()) {
        extract($params);
        require_once _DIR_ . '/Layout/Default.php';
    }

}
