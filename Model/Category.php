<?php

namespace Model;

class Category {

    public static function getCategoriesList() {

        $db = \System\Db::getInstance()->getInstance();
        $result = $db->query('SELECT id, name FROM categories ORDER BY id ASC');

        $categoryList = array();
        $i = 0;
        while ($category = $result->fetch()) {
            $categoryList[$i]['id'] = $category['id'];
            $categoryList[$i]['name'] = $category['name'];
            $i++;
        }
        return $categoryList;
    }

}
