<?php

namespace Controller;

class Home {
    
    public function actionHome() {
       
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('/Layout/home.php');
    }

}
