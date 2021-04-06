<?php

namespace Model\Admin;

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

    public static function assignProductToCategory($categoryId, $productId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO category_products (id, categoryId, productId) VALUES (NULL, :categoryId, :productId)');
        $result->bindParam(':categoryId', $categoryId, \PDO::PARAM_INT);
        $result->bindParam(':productId', $productId, \PDO::PARAM_STR);
        $result->execute();
        return $result;
    }

    public static function deleteProductFromCategory($id, $productId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('DELETE FROM category_products WHERE categoryId = :id AND productId = :productId');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->bindParam(':productId', $productId, \PDO::PARAM_INT);

        return $result->execute();
    }

    public static function getCategoryProducts($id) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->query('SELECT productId FROM category_products WHERE categoryId = ' . $id . '');

        $productIdList = [];

        foreach ($result as $product) {

            $productIdList[] = $product['productId'];
        }
        return $productIdList;
    }

    public static function getProductById($id) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('SELECT * FROM products WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    public static function deleteProductById($id) {
        $db = \System\Db::getInstance()->getPDO();

        $result = $db->prepare('DELETE FROM products WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        return $result->execute();
    }

    public static function deleteProductCategoryRelation($id) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('DELETE FROM category_products WHERE productId = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        return $result->execute();
    }

    public static function updateProductById($id, $options) {
        $db = \System\Db::getInstance()->getPDO();

        $result = $db->prepare('UPDATE products SET name = :name, sku = :sku, qty=:qty, price = :price, description = :description WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], \PDO::PARAM_STR);
        $result->bindParam(':qty', $options['qty'], \PDO::PARAM_INT);
        $result->bindParam(':sku', $options['sku'], \PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], \PDO::PARAM_STR);
        $result->bindParam(':description', $options['description'], \PDO::PARAM_STR);
        $result->execute();
        return $result;
    }

    public static function createProduct($options) {
        $db = \System\Db::getInstance()->getPDO();

        $result = $db->prepare('INSERT INTO products (id, sku, qty, name, description, price) VALUES (NULL, :sku, :qty, :name, :description, :price)');
        $result->bindParam(':name', $options['name'], \PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], \PDO::PARAM_STR);
        $result->bindParam(':qty', $options['qty'], \PDO::PARAM_INT);
        $result->bindParam(':sku', $options['sku'], \PDO::PARAM_STR);
        $result->bindParam(':description', $options['description'], \PDO::PARAM_STR);

        if ($result->execute()) {
            return $db->lastInsertId();
        }
        echo 'error';
    }

    public static function insertImagePath($id) {
        $db = \System\Db::getInstance()->getPDO();

        $result = $db->prepare('UPDATE products SET image="/media/images/' . $id . '.jpg" WHERE id= :id ');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->execute();
        return $result;
    }

    public static function getImage($id) {
        $noImage = 'no-image.jpg';

        $path = '/media/images/';

        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists(_DIR_PUB_ . $pathToProductImage)) {

            return $pathToProductImage;
        }

        return $path . $noImage;
    }

}
