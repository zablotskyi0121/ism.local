<?php

namespace Model;

class Product {

    public static function getAllProduct() {

        $_instance = \System\Db::getInstance()->getInstance();

        $productList = array();

        $result = $_instance->query('SELECT Id, SKU, Name, Price, Description, Image FROM Ism.products ORDER BY id ASC');

        $i = 0;
        while ($phones = $result->fetch()) {
            $productList[$i]['Id'] = $phones['Id'];
            $productList[$i]['SKU'] = $phones['SKU'];
            $productList[$i]['Name'] = $phones['Name'];
            $productList[$i]['Price'] = $phones['Price'];
            $productList[$i]['Description'] = $phones['Description'];
            $productList[$i]['Image'] = $phones['Image'];

            $i++;
        }

        return $productList;
    }

}
