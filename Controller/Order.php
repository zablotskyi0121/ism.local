<?php

namespace Controller;

class Order {
    
    public function actionCheckout() {

        $userId = \System\App::getUserId();
        $quoteId = \Model\Cart::checkIfQuoteExist($userId);
        $productsInCart = \Model\Cart::getProductsForQuote($quoteId);

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
            $orderId = \Model\Order::insertOrder($totalPrice, $userId, $userName, $userEmail, $userPhone, $userComment);

            foreach ($productsInCart as $product) {
                $id = $product['productId'];
                $productPrice = \Model\Cart::getProductPrice($id, $quoteId);
                $qty = $product['sum(qty)'];
                \Model\Order::insertOrderItem($orderId, $id, $productPrice, $qty);
            }
            if ($orderId) {
                \Model\Cart::clearCart($quoteId);
            }
            header("Location: /order/success");
        }
    }

    public function actionSuccess() {

        $userId = \System\App::getUserId();
        $orderId = \Model\Order::getOrderId($userId);
        \System\Renderer::render('SuccessPage', ['orderId' => $orderId]);
    }
}
