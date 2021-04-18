<?php

namespace Model;

class User {

    public static function getUserId($sessionId) {
        $db = \System\Db::getInstance()->getPDO();

        $result = $db->prepare('SELECT * FROM user WHERE sessionId = :sessionId');
        $result->bindParam(':sessionId', $sessionId, \PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }
        return false;
    }

    public static function insertSession($sessionId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO user (id, sessionId) VALUES (NULL, :sessionId)');
        $result->bindParam(':sessionId', $sessionId, \PDO::PARAM_STR);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
    }

    public static function insertQuote($userId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO quote (id, userId) VALUES (NULL, :userId)');
        $result->bindParam(':userId', $userId, \PDO::PARAM_INT);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
    }

    public static function checkOrQuoteExist($userId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('SELECT * FROM quote WHERE userId = :userId');
        $result->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $result->execute();
        $quote = $result->fetch();
        if ($quote) {
            return $quote['id'];
        }
        return false;
    }

    public static function insertQuoteItem($quoteId, $productId, $qty) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO `quoteItem`(`id`, `quoteId`, `productId`, `qty`) VALUES (NULL, :quoteId, :productId, :qty)');
        $result->bindParam(':quoteId', $quoteId, \PDO::PARAM_INT);
        $result->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $result->bindParam(':qty', $qty, \PDO::PARAM_INT);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
    }

    public static function getProductsForQuote($quoteId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->query('SELECT productId, sum(qty) FROM `quoteItem` WHERE quoteId = ' . $quoteId . ' GROUP BY productId');

        $quoteItemList = [];
        $i = 0;
        while ($quoteItem = $result->fetch()) {
            $quoteItemList[$i]['productId'] = $quoteItem['productId'];
            $quoteItemList[$i]['sum(qty)'] = $quoteItem['sum(qty)'];

            $i++;
        }

        return $quoteItemList;
    }

    public static function insertOrder($userId, $userName, $userEmail, $userPhone, $userComment) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO `order`(`id`, `userId`, `created`, `userName`, `userEmail`, `userPhone`, `userComment`) VALUES (NULL, :userId, NOW(), :userName, :userEmail, :userPhone, :userComment)');
        $result->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $result->bindParam(':userName', $userName, \PDO::PARAM_STR);
        $result->bindParam(':userEmail', $userEmail, \PDO::PARAM_STR);
        $result->bindParam(':userPhone', $userPhone, \PDO::PARAM_STR);
        $result->bindParam(':userComment', $userComment, \PDO::PARAM_STR);

        if ($result->execute()) {
            return $db->lastInsertId();
        }
    }

    public static function insertOrderItem($orderId, $productId, $qty) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO `orderItem`(`id`, `orderId`, `productId`, `qty`) VALUES (NULL, :orderId, :productId, :qty)');
        $result->bindParam(':orderId', $orderId, \PDO::PARAM_INT);
        $result->bindParam(':productId', $productId, \PDO::PARAM_INT);
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

    public static function clearCart($quoteId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('DELETE FROM quoteItem WHERE quoteId = :quoteId');
        $result->bindParam(':quoteId', $quoteId, \PDO::PARAM_INT);
        return $result->execute();
    }

}
