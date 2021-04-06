<?php

namespace Model\Admin;

class Category {

    public static function getCategoriesList() {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->query('SELECT id, name, description, image FROM categories ORDER BY id ASC');

        $categoryList = array();
        $i = 0;
        while ($category = $result->fetch()) {
            $categoryList[$i]['id'] = $category['id'];
            $categoryList[$i]['name'] = $category['name'];
            $categoryList[$i]['description'] = $category['description'];
            $categoryList[$i]['image'] = $category['image'];
            $i++;
        }
        return $categoryList;
    }

    public static function createCategory($name, $description) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO categories (id, name, description) VALUES (NULL, :name, :description)');
        $result->bindParam(':name', $name, \PDO::PARAM_STR);
        $result->bindParam(':description', $description, \PDO::PARAM_STR);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
        echo 'error';
    }

    public static function updateCategoryById($id, $name, $description) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('UPDATE categories SET name = :name, description = :description WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->bindParam(':name', $name, \PDO::PARAM_STR);
        $result->bindParam(':description', $description, \PDO::PARAM_STR);
        $result->execute();
        return $result;
    }

    public static function getCategoryById($id) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('SELECT * FROM categories WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    public static function deleteCategoryById($id) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('DELETE FROM categories WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        return $result->execute();
    }

    public static function deleteCategoryProductRelation($id) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('DELETE FROM category_products WHERE categoryId = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        return $result->execute();
    }

    public static function getImage($id) {
        $noImage = 'no-image.jpg';

        $path = '/media/images/category/';

        $pathToCategoryImage = $path . $id . '.jpg';

        if (file_exists(_DIR_PUB_ . $pathToCategoryImage)) {

            return $pathToCategoryImage;
        }

        return $path . $noImage;
    }

}
