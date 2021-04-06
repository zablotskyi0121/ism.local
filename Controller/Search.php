<?php

namespace Controller;

class Search {

    public function actionSearch() {

        $keyword = isset($_GET['search']) ? $_GET['search'] : null;
        $productSearch = new \Model\Search();
        $searchResult = $productSearch->productSearch($keyword);
        \System\Renderer::render('Search', ['searchResult' => $searchResult]);
    }

}
