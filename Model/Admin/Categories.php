<?php

namespace Model\Admin;

class Categories {
    
    public static function getCategoriesList(){
        
        $db = \System\Db::getInstance()->getInstance();
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
}
