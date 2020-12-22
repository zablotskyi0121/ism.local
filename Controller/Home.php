<?php

namespace Controller;

class Home {

    public function actionHome() {

        $categoryURL = 'Category';
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('/View/home.php', ['Category' => $categoryURL]);
    }

}
