<?php

namespace Controller;

class Error404 {

    public static function page404() {

        echo 'Page not found';
        header("HTTP/1.0 404 Not Found");
    }

}
