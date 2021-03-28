<?php

namespace Model;

class Product {

    public static function getAllProduct() {

        $db = \System\Db::getInstance()->getPDO();

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

    public static function getProductsPerCategoty($categoryId) {

        $db = \System\Db::getInstance()->getPDO();
        $product = $db->query('SELECT * FROM `products` JOIN `category_products` ON products.id = category_products.productId WHERE products.id = category_products.productId AND category_products.categoryId = ' . $categoryId . ' ');

        $productList = [];
        $i = 0;
        while ($phones = $product->fetch()) {
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
