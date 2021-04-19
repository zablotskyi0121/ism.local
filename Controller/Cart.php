<?php

namespace Controller;

class Cart {

    public function actionAdd($id) {

        $qty = $_POST['quantity'];

        $userId = \System\App::getUserId();
        $quoteId = \Model\User::checkOrQuoteExist($userId);
        if ($quoteId == 0) {
            $quoteId = \Model\User::insertQuote($userId);
        }

        \Model\User::insertQuoteItem($quoteId, $id, $qty);

        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");

        return self::countItems();
    }

    public function actionView() {

        $userId = \System\App::getUserId();
        $quoteId = \Model\User::checkOrQuoteExist($userId);
        $productsInCart = \Model\User::getProductsForQuote($quoteId);

        $productCartData = [];
        $ids = [];

        foreach ($productsInCart as $product) {
            $productCartData[$product['productId']] = $product['sum(qty)'];
            $ids[] = $product['productId'];
        }
        if ($productsInCart) {

            $productsIds = implode(',', $ids);

            $productList = \Model\Product::getProdustsByIds($productsIds);
        } else {
            \System\Renderer::render('EmptyCart', []);
            exit();
        }

        $totalPrice = 0;

        foreach ($productList as $key => $item) {
            $productList[$key]['qty'] = $productCartData[$item['id']];
            $totalPrice += $item['price'] * $productList[$key]['qty'];
        }


        \System\Renderer::render('Cart', ['productList' => $productList, 'productsInCart' => $productsInCart, 'totalPrice' => $totalPrice]);
    }

    public function actionCheckout() {

        $userId = \System\App::getUserId();
        $quoteId = \Model\User::checkOrQuoteExist($userId);
        $productsInCart = \Model\User::getProductsForQuote($quoteId);

        $productCartData = [];
        $ids = [];

        foreach ($productsInCart as $product) {
            $productCartData[$product['productId']] = $product['sum(qty)'];
            $ids[] = $product['productId'];
        }
        $productsIds = implode(',', $ids);
        $productList = \Model\Product::getProdustsByIds($productsIds);

        $totalPrice = 0;

        foreach ($productList as $key => $item) {
            $productList[$key]['qty'] = $productCartData[$item['id']];
            $totalPrice += $item['price'] * $productList[$key]['qty'];
        }

        $totalQuantity = \Controller\Cart::countItems();
        \System\Renderer::render('Checkout', ['totalQuantity' => $totalQuantity, 'totalPrice' => $totalPrice]);

        $userName = false;
        $userEmail = false;
        $userPhone = false;
        $userComment = false;

        if (isset($_POST['submit'])) {
            $userName = $_POST['userName'];
            $userEmail = $_POST['userEmail'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            $orderId = \Model\User::insertOrder($userId, $userName, $userEmail, $userPhone, $userComment);

            foreach ($productsInCart as $product) {
                $id = $product['productId'];
                $qty = $product['sum(qty)'];
                \Model\User::insertOrderItem($orderId, $id, $qty);
            }
            if ($orderId) {
                \Model\User::clearCart($quoteId);
            }
            header("Location: /cart/success");
        }
    }

    public function actionSuccess() {

        $userId = \System\App::getUserId();
        $orderId = \Model\User::getOrderId($userId);
        \System\Renderer::render('SuccessPage', ['orderId' => $orderId]);
    }

    public function actionDelete($id) {

        $userId = \System\App::getUserId();
        $quoteId = \Model\User::checkOrQuoteExist($userId);
        \Model\Product::deleteProduct($id, $quoteId);
        header("Location: /cart/view");
    }

    public static function countItems() {

        $userId = \System\App::getUserId();
        if (($quoteId = \Model\User::checkOrQuoteExist($userId))) {

            $count = \Model\Product::sumProductsInCart($quoteId);
            return $count;
        } else {

            return 0;
        }
    }

}
