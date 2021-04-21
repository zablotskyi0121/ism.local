<?php

namespace Model\Admin;

class Order {

    public static function getOrdersList() {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->query('SELECT `id`, `totalPrice`, `userId`, `created`, `userName`, `userEmail`, `userPhone`, `userComment` FROM `order` ORDER BY id ASC ');

        $orderList = array();
        $i = 0;
        while ($order = $result->fetch()) {
            $orderList[$i]['id'] = $order['id'];
            $orderList[$i]['totalPrice'] = $order['totalPrice'];
            $orderList[$i]['userId'] = $order['userId'];
            $orderList[$i]['created'] = $order['created'];
            $orderList[$i]['userName'] = $order['userName'];
            $orderList[$i]['userEmail'] = $order['userEmail'];
            $orderList[$i]['userPhone'] = $order['userPhone'];
            $orderList[$i]['userComment'] = $order['userComment'];

            $i++;
        }
        return $orderList;
    }
    
    public static function getOrderById($id) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('SELECT * FROM `order` WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    
    public static function getProductsPerOrder($orderId) {

        $db = \System\Db::getInstance()->getPDO();
        $product = $db->query('SELECT products.id, products.sku, products.name, orderItem.productPrice, products.image, orderItem.qty FROM `products` JOIN `orderItem` ON products.id = orderItem.productId WHERE orderItem.orderId = ' . $orderId . ' ');

        $productList = [];
        $i = 0;
        while ($order = $product->fetch()) {
            $productList[$i]['id'] = $order['id'];
            $productList[$i]['sku'] = $order['sku'];
            $productList[$i]['name'] = $order['name'];
            $productList[$i]['productPrice'] = $order['productPrice'];
            $productList[$i]['image'] = $order['image'];
            $productList[$i]['qty'] = $order['qty'];

            $i++;
        }

        return $productList;
    }

}
