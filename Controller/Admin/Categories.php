<?php

namespace Controller\Admin;

class Categories {

    public function actionIndex() {

        $categoryList = \Model\Admin\Categories::getCategoriesList();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Category/CategoryList', ['categoryList' => $categoryList], true);
    }

    public function actionCreate() {

        $productList = \Model\Admin\Products::getAllProductsForCategory();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Category/CreateCategory', ['productList' => $productList], true);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $id = \Model\Admin\Categories::createCategory($name, $description);

            if ($id) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/category/{$id}.jpg");
                }
            };

            header("Location: /admin/categories/index");
        }
    }

    public function actionUpdate($id) {

        $category = \Model\Admin\Categories::getCategoryById($id);
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Category/UpdateCategory', ['category' => $category], true);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];

            if (\Model\Admin\Categories::updateCategoryById($id, $name, $description)) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/category/{$id}.jpg");
                }
            }

            header("Location: /admin/categories/index");
        }
    }

    public function actionDelete($id) {

        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Category/DeleteCategory', ['id' => $id], true);

        if (isset($_POST['submit'])) {
            \Model\Admin\Categories::deleteCategoryById($id);
            header("Location: /admin/categories/index");
        }
        return true;
    }

}
