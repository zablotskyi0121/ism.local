<?php

namespace Controller;

class Product {
        
    public static function getList() {

        
        $productList = \Model\Product::getAllProduct();
             
        require_once _DIR_ . '/View/productList.phtml';        
    } 
}
