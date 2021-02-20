<?php

namespace Controller\Admin;

class Categories {

    public function actionIndex() {

        $categoryList = \Model\Admin\Categories::getCategoriesList();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Category/CategoryList', ['categoryList' => $categoryList]);
    }

}
