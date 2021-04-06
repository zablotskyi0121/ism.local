<?php

namespace Controller;

class Cart {

    public function actionAdd($id) {

        $productsInCart = array();
        $quantity = $_POST['quantity'];

        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }

        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] = $productsInCart[$id] + $quantity;
        } else {
            $productsInCart[$id] = $quantity;
        }

        $_SESSION['products'] = $productsInCart;


        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");

        return self::countItems();
    }

    public function actionView() {

        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];

            if ($productsInCart) {
                $productsIds = array_keys($productsInCart);
                $productList = \Model\Product::getProdustsByIds($productsIds);
            } else {
                $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
                \System\Renderer::render('EmptyCart', ['categories' => $categories]);
                exit();
            }

            $totalPrice = 0;

            foreach ($productList as $item) {
                $totalPrice += $item['price'] * $productsInCart[$item['id']];
            }
        }

        $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
        \System\Renderer::render('Cart', ['productList' => $productList, 'categories' => $categories, 'productsInCart' => $productsInCart, 'totalPrice' => $totalPrice]);
    }

    public function actionCheckout() {

        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];

            if (isset($_SESSION['products'])) {
                $productsInCart = $_SESSION['products'];
            }

            $productsIds = array_keys($productsInCart);
            $productList = \Model\Product::getProdustsByIds($productsIds);

            $totalPrice = 0;

            foreach ($productList as $item) {
                $totalPrice += $item['price'] * $productsInCart[$item['id']];
            }

            $totalQuantity = \Controller\Cart::countItems();

            $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
            \System\Renderer::render('Checkout', ['totalQuantity' => $totalQuantity, 'categories' => $categories, 'totalPrice' => $totalPrice]);

            $userName = false;
            $userPhone = false;
            $userComment = false;

            if (isset($_POST['submit'])) {
                $userName = $_POST['userName'];
                $userPhone = $_POST['userPhone'];
                $userComment = $_POST['userComment'];
                
                echo 'test';
            }
        }
    }

    public function actionDelete($id) {

        $productsInCart = $_SESSION['products'];
        unset($productsInCart[$id]);
        $_SESSION['products'] = $productsInCart;

        header("Location: /cart/view");
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
