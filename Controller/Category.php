<?php

namespace Controller;

class Category {

    public function actionIndex() {

        $category = \Model\Category::getCategoriesList();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Menu', ['category' => $category]);
    }
    
    public function actionCategory($categoryId) {
        
        $category = \Model\Category::getCategoriesList();
        $productList = \Model\Product::getAllProduct();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('POP', ['productList' => $productList]);
    }

}
