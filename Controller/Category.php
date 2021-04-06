<?php

namespace Controller;

class Category {

    public function actionView($categoryId) {

        $productList = \Model\Product::getProductsPerCategoty($categoryId);
        \System\Renderer::render('POP', ['productList' => $productList]);
    }

}
