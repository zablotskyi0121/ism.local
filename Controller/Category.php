<?php

namespace Controller;

class Category {

    public function actionList() {

        $categories = \Model\Category::getCategoriesList();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Menu', ['categories' => $categories]);
    }

    public function actionView($categoryId) {

        $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
        $productList = \Model\Product::getAllProduct();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('POP', ['productList' => $productList, 'categories' => $categories]);
    }

}
