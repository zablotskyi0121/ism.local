<?php

namespace Controller\Admin;

class Categories {

    public function actionIndex() {

        $categoryList = \Model\Admin\Categories::getCategoriesList();
        \System\Renderer::render('Admin/Category/List', ['categoryList' => $categoryList], true);
    }

    public function actionCreate() {

        $productList = \Model\Admin\Products::getAllProduct();
        \System\Renderer::render('Admin/Category/Create', ['productList' => $productList], true);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $products = $_POST['productList'];

            $id = \Model\Admin\Categories::createCategory($name, $description);

            if ($id) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/category/{$id}.jpg");
                }

                foreach ($products as $productId) {
                    \Model\Admin\Products::assignProductToCategory($id, $productId);
                }
            }
            header("Location: /admin/categories/index");
        }
    }

    public function actionUpdate($id) {

        $category = \Model\Admin\Categories::getCategoryById($id);
        $productList = \Model\Admin\Products::getAllProduct(); 
        $categoryProducts = \Model\Admin\Products::getCategoryProducts($id); 

        \System\Renderer::render('Admin/Category/Update', ['category' => $category, 'productList' => $productList, 'categoryProducts' => $categoryProducts], true);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $products = $_POST['productList'];

            if (\Model\Admin\Categories::updateCategoryById($id, $name, $description)) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/category/{$id}.jpg");
                }
            }

            //insert new products 
            foreach ($products as $productId) {

                if (!in_array($productId, $categoryProducts)) {
                    \Model\Admin\Products::assignProductToCategory($id, $productId);
                }
            }

            //delete products
            foreach ($categoryProducts as $productId) {

                if (!in_array($productId, $products)) {
                    \Model\Admin\Products::deleteProductFromCategory($id, $productId);
                }
            }

            header("Location: /admin/categories/index");
        }
    }

    public function actionDelete($id) {

        \System\Renderer::render('Admin/Category/Delete', ['id' => $id], true);

        if (isset($_POST['submit'])) {
            \Model\Admin\Categories::deleteCategoryById($id);
            \Model\Admin\Categories::deleteCategoryProductRelation($id);
            header("Location: /admin/categories/index");
        }
        return true;
    }

}
