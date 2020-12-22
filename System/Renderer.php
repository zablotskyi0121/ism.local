<?php

namespace System;

class Renderer {

    public function render($template, $params) {
        extract($params);
        require_once _DIR_ . $template;
    }

}
