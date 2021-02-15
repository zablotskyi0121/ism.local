<?php

namespace Model;

class Search {

    public function productSearch($keyword) {

        $db= \System\Db::getInstance()->getInstance();
        $productList = array();
        $result = $db->query("SELECT * FROM Ism.products WHERE sku like '%$keyword%' OR name like '%$keyword%' OR description like '%$keyword%'");
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
