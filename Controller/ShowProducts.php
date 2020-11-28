<?php

namespace Controller;

class ShowProducts {
        
    public static function actionProduct() {

        
        $productList = \Model\GetProductData::getProductFromDB();
             
        require_once _DIR_ . '/View/productList.phtml';        
        
    } 
}
