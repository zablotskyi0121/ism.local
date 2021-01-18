<?php

namespace Model;

class Search {

    public function productSearch($keyword) {

        $_instance = \System\Db::getInstance()->getInstance();
        $productList = array();

        $result = $_instance->query("SELECT * FROM Ism.products WHERE SKU like '%$keyword%' OR Name like '%$keyword%' OR Description like '%$keyword%'");
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
