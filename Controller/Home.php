<?php

namespace Controller;

class Home {

    public function actionHome() {

        $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Home', ['categories' => $categories]);
    }

}
