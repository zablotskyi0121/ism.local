<?php

namespace Model;

class Cart {

    public static function insertQuote($userId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO quote (id, userId, totalPrice) VALUES (NULL, :userId, 0)');
        $result->bindParam(':userId', $userId, \PDO::PARAM_INT);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
    }

    public static function setTotalPriceForQuote($totalPrice, $userId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('UPDATE `quote` SET `totalPrice`= :totalPrice WHERE `userId`= :userId');
        $result->bindParam(':totalPrice', $totalPrice, \PDO::PARAM_STR);
        $result->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    public static function checkIfQuoteExist($userId) {

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

    public static function insertQuoteItem($quoteId, $productId, $productPrice, $qty) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO `quoteItem`(`id`, `quoteId`, `productId`, `productPrice`, `qty`) VALUES (NULL, :quoteId, :productId, :productPrice, :qty)');
        $result->bindParam(':quoteId', $quoteId, \PDO::PARAM_INT);
        $result->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $result->bindParam(':productPrice', $productPrice, \PDO::PARAM_INT);
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

    public static function getProductPrice($productId, $quoteId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('SELECT `productPrice` FROM `quoteItem` WHERE `productId` = :productId AND `quoteId` = :quoteId ');
        $result->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $result->bindParam(':quoteId', $quoteId, \PDO::PARAM_INT);
        $result->execute();
        $productPrice = $result->fetch();
        if ($productPrice) {
            return $productPrice['productPrice'];
        }
        return false;
    }

    public static function deleteProduct($id, $quoteId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('DELETE FROM `quoteItem` WHERE productId = :id AND quoteId = :quoteId');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->bindParam(':quoteId', $quoteId, \PDO::PARAM_INT);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    public static function sumProductsInCart($quoteId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('SELECT sum(qty) FROM `quoteItem` WHERE quoteId = :quoteId ');
        $result->bindParam(':quoteId', $quoteId, \PDO::PARAM_INT);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute();
        $row = $result->fetch();
        if ($row) {
            $sum = $row['sum(qty)'];
        }
        return $sum;
    }

    public static function clearCart($quoteId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('DELETE FROM quoteItem WHERE quoteId = :quoteId');
        $result->bindParam(':quoteId', $quoteId, \PDO::PARAM_INT);
        return $result->execute();
    }

}
