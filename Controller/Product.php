<?php

namespace Controller;

class Product {

    public function actionList() {


        $productList = \Model\Product::getAllProduct();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('/Layout/productList.phtml', ['productList' => $productList]);
    }

}
