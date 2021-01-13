<?php

namespace System;

class Renderer {

    public function render($template, $params = array()) { 
        extract($params);
        require_once _DIR_ . $template;
    }

}
