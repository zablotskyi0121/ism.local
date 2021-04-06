<?php

namespace Controller\Admin;

class Category {

    public function actionIndex() {

        $categoryList = \Model\Admin\Category::getCategoriesList();
        \System\Renderer::render('Admin/Category/List', ['categoryList' => $categoryList], true);
    }

    public function actionCreate() {

        $productList = \Model\Admin\Product::getAllProduct();
        \System\Renderer::render('Admin/Category/Create', ['productList' => $productList], true);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $products = $_POST['productList'];

            $id = \Model\Admin\Category::createCategory($name, $description);

            if ($id) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/category/{$id}.jpg");
                }

                foreach ($products as $productId) {
                    \Model\Admin\Product::assignProductToCategory($id, $productId);
                }
            }
            header("Location: /admin/category/index");
        }
    }

    public function actionUpdate($id) {

        $category = \Model\Admin\Category::getCategoryById($id);
        $productList = \Model\Admin\Product::getAllProduct(); 
        $categoryProducts = \Model\Admin\Product::getCategoryProducts($id); 

        \System\Renderer::render('Admin/Category/Update', ['category' => $category, 'productList' => $productList, 'categoryProducts' => $categoryProducts], true);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $products = $_POST['productList'];

            if (\Model\Admin\Category::updateCategoryById($id, $name, $description)) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/category/{$id}.jpg");
                }
            }

            //insert new products 
            foreach ($products as $productId) {

                if (!in_array($productId, $categoryProducts)) {
                    \Model\Admin\Product::assignProductToCategory($id, $productId);
                }
            }

            //delete products
            foreach ($categoryProducts as $productId) {

                if (!in_array($productId, $products)) {
                    \Model\Admin\Product::deleteProductFromCategory($id, $productId);
                }
            }

            header("Location: /admin/category/index");
        }
    }

    public function actionDelete($id) {

        \System\Renderer::render('Admin/Category/Delete', ['id' => $id], true);

        if (isset($_POST['submit'])) {
            \Model\Admin\Category::deleteCategoryById($id);
            \Model\Admin\Category::deleteCategoryProductRelation($id);
            header("Location: /admin/category/index");
        }
        return true;
    }

}
