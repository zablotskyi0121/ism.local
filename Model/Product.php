<?php

namespace Model;

class Product {

    public static function getAllProduct() {

        $db = \System\Db::getInstance()->getInstance();

        $productList = array();

        $result = $db->query('SELECT id, sku, name, price, description, image FROM products ORDER BY id ASC');

        $i = 0;
        while ($phones = $result->fetch()) {
            $productList[$i]['id'] = $phones['id'];
            $productList[$i]['sku'] = $phones['sku'];
            $productList[$i]['name'] = $phones['name'];
            $productList[$i]['price'] = $phones['price'];
            $productList[$i]['description'] = $phones['description'];
            $productList[$i]['image'] = $phones['image'];

            $i++;
        }

        return $productList;
    }

}
