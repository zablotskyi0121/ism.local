<?php

namespace Controller;

class Product {

    public function actionList() {

        $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
        $productList = \Model\Product::getAllProduct();
        \System\Renderer::render('POP', ['productList' => $productList, 'categories' => $categories]);
    }

    public function actionView($id) {

        $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
        $product = \Model\Product::getProductById($id);
        \System\Renderer::render('PDP', ['product' => $product, 'categories' => $categories]);
    }

}
