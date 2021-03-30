<?php

namespace Controller;

class Error503 {

    public static function page503() {
        header("HTTP/1.0 503 Service Unavailable");
        
        echo '<div style="color:#F00; text-align:center; top:15%; position:absolute;"> Sorry, somesing went wrong. Please see logs file. </div>';
    }

}
