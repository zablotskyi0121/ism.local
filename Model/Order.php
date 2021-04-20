<?php

namespace Model;

class Order {

    public static function insertOrder($totalPrice, $userId, $userName, $userEmail, $userPhone, $userComment) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO `order`(`id`, `totalPrice`, `userId`, `created`, `userName`, `userEmail`, `userPhone`, `userComment`) VALUES (NULL, :totalPrice, :userId, NOW(), :userName, :userEmail, :userPhone, :userComment)');
        $result->bindParam(':totalPrice', $totalPrice, \PDO::PARAM_STR);
        $result->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $result->bindParam(':userName', $userName, \PDO::PARAM_STR);
        $result->bindParam(':userEmail', $userEmail, \PDO::PARAM_STR);
        $result->bindParam(':userPhone', $userPhone, \PDO::PARAM_STR);
        $result->bindParam(':userComment', $userComment, \PDO::PARAM_STR);

        if ($result->execute()) {
            return $db->lastInsertId();
        }
    }

    public static function insertOrderItem($orderId, $productId, $productPrice, $qty) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO `orderItem`(`id`, `orderId`, `productId`, `productPrice`, `qty`) VALUES (NULL, :orderId, :productId, :productPrice, :qty)');
        $result->bindParam(':orderId', $orderId, \PDO::PARAM_INT);
        $result->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $result->bindParam(':productPrice', $productPrice, \PDO::PARAM_INT);
        $result->bindParam(':qty', $qty, \PDO::PARAM_INT);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
    }

    public static function getOrderId($userId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('SELECT id FROM `order` WHERE userId = :userId ORDER BY id DESC LIMIT 1');
        $result->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $result->execute();
        $order = $result->fetch();
        if ($order) {
            return $order['id'];
        }
        return false;
    }

}
