<?php

namespace Controller;

class Home {
    
    public $template;

    public function actionHome() {
       
        $templatePath = 'Template';
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('/Layout/home.php', ['Template' => $templatePath]);
    }

}
