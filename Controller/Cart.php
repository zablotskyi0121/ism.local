<?php

namespace Controller;

class Cart {

    public function actionAdd($id) {

        $qty = $_POST['quantity'];

        $userId = \System\App::getUserId();
        $quoteId = \Model\Cart::checkIfQuoteExist($userId);
        if (!$quoteId) {
            $quoteId = \Model\Cart::insertQuote($userId);
        }
        $productPrice = \Model\Product::getProductPrice($id);
        \Model\Cart::insertQuoteItem($quoteId, $id, $productPrice, $qty);

        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");

        return self::countItems();
    }

    public function actionView() {

        $userId = \System\App::getUserId();
        $quoteId = \Model\Cart::checkIfQuoteExist($userId);
        $productsInCart = \Model\Cart::getProductsForQuote($quoteId);

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

        \Model\Cart::setTotalPriceForQuote($totalPrice, $userId);
        \System\Renderer::render('Cart', ['productList' => $productList, 'productsInCart' => $productsInCart, 'totalPrice' => $totalPrice]);
    }

    public function actionDelete($id) {

        $userId = \System\App::getUserId();
        $quoteId = \Model\Cart::checkIfQuoteExist($userId);
        \Model\Cart::deleteProduct($id, $quoteId);
        header("Location: /cart/view");
    }

    public static function countItems() {

        $userId = \System\App::getUserId();
        if (($quoteId = \Model\Cart::checkIfQuoteExist($userId))) {

            $count = \Model\Cart::sumProductsInCart($quoteId);
            return $count;
        } else {

            return 0;
        }
    }

}
