<?php

namespace Controller;

class Checkout {

    public function actionAdd($id) {

        $productsInCart = array();

        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }

        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id]++;
        } else {
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;
       
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
        
        return self::countItems();
    }

    public static function countItems() {
        
        if (isset($_SESSION['products'])) {
            
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            
            return 0;
        }
    }

}
