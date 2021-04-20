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

}
