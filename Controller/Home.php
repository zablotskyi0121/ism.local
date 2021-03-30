<?php

namespace Controller;

class Home {

    public function actionHome() {

        $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
        \System\Renderer::render('Home', ['categories' => $categories]);
    }

}
