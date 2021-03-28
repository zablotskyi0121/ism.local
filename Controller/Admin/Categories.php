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
            $products = $_POST['productList'];

            $id = $categoryId = \Model\Admin\Categories::createCategory($name, $description);

            if ($id) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/category/{$id}.jpg");
                }
            }
            foreach ($products as $productId) {
                \Model\Admin\Products::assignProductToCategory($categoryId, $productId);
            }

            header("Location: /admin/categories/index");
        }
    }

    public function actionUpdate($id) {

        $category = \Model\Admin\Categories::getCategoryById($id);
        $productList = \Model\Admin\Products::getAllProductsForCategory();
        $productIdArray = \Model\Admin\Products::getProductIdPerCategotyList($id);

        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Category/UpdateCategory', ['category' => $category, 'productList' => $productList, 'productIdArray' => $productIdArray], true);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $productsInput = $_POST['productList'];

            if (\Model\Admin\Categories::updateCategoryById($id, $name, $description)) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/category/{$id}.jpg");
                }
            }

            //insert new products 
            foreach ($productsInput as $productId) {

                if (!in_array($productId, $productIdArray)) {
                    \Model\Admin\Products::assignProductToCategory($id, $productId);
                }
            }

            //delete products
            foreach ($productIdArray as $productId) {

                if (!in_array($productId, $productsInput)) {
                    \Model\Admin\Products::deleteProductFromCategory($id, $productId);
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
            \Model\Admin\Categories::deleteCategoryProductRelation($id);
            header("Location: /admin/categories/index");
        }
        return true;
    }

}
