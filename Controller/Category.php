<?php

namespace Controller;

class Category {

    public function actionList() {

        $categories = \Model\Category::getCategoriesList();
        \System\Renderer::render('Menu', ['categories' => $categories]);
    }

    public function actionView($categoryId) {

        $productList = \Model\Product::getProductsPerCategoty($categoryId);
        \System\Renderer::render('POP', ['productList' => $productList]);
    }

}
