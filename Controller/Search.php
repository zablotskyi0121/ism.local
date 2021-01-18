<?php

namespace Controller;

class Search {

    public function actionSearch() {

        $keyword = isset($_POST['search']) ? $_POST['search'] : null;

        $productSearch = new \Model\Search();
        $searchResult = $productSearch->productSearch($keyword);
        $renderer = new \System\Renderer();
        
        $renderer = $renderer->render('Search', ['searchResult' => $searchResult]);
    }

}
