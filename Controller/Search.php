<?php

namespace Controller;

class Search {

    public function actionSearch() {

        $keyword = isset($_GET['search']) ? $_GET['search'] : null;
        $productSearch = new \Model\Search();
        $searchResult = $productSearch->productSearch($keyword);
        $categories = \System\App::getModel(\Model\Category::class)->getCategoriesList();
        \System\Renderer::render('Search', ['searchResult' => $searchResult, 'categories' => $categories]);
    }

}
