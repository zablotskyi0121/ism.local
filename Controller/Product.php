<?php

namespace Controller;

class Product {

    public function actionList() {

        $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
        $productList = \Model\Product::getAllProduct();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('POP', ['productList' => $productList, 'categories' => $categories]);
    }

}
