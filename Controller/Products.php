<?php

namespace Controller;

class Products extends \System\AdminBase {

    public function actionIndex() {
        self::checkAdmin();
        $productList = \Model\Product::getAllProduct();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/ProductList', ['productList' => $productList]);
    }

}
