<?php

namespace Controller;

class Product {
        
    public function getList() {

        
        $productList = \Model\Product::getAllProduct();
        $renderer = new \System\Renderer();   
        $renderer = $renderer->render('/View/productList.phtml', ['productList'=> $productList]);
        
              
    } 
}
