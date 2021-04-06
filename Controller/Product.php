<?php

namespace Controller;

class Product {

    public function actionList() {

        $productList = \Model\Product::getAllProduct();
        \System\Renderer::render('POP', ['productList' => $productList]);
    }

    public function actionView($id) {

        $product = \Model\Product::getProductById($id);
        \System\Renderer::render('PDP', ['product' => $product]);
    }

}
