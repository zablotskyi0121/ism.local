<?php

namespace Controller\Admin;

class Products {

    public function actionIndex() {

        $productList = \Model\Admin\Products::getAllProduct();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Product/ProductList', ['productList' => $productList], true);
    }

    public function actionCreate() {

        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Product/CreateProduct', [], true);

        if (isset($_POST['submit'])) {

            $options['name'] = $_POST['name'];
            $options['price'] = $_POST['price'];
            $options['qty'] = $_POST['qty'];
            $options['sku'] = $_POST['sku'];
            $options['description'] = $_POST['description'];

            $id = \Model\Admin\Products::createProduct($options);

            if ($id) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/{$id}.jpg");
                }
            };

            header("Location: /admin/products/index");
        }

        return true;
    }

    public function actionUpdate($id) {

        $product = \Model\Admin\Products::getProductById($id);

        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Product/UpdateProduct', ['id' => $id, 'product' => $product], true);

        if (isset($_POST['submit'])) {

            $options['name'] = $_POST['name'];
            $options['sku'] = $_POST['sku'];
            $options['price'] = $_POST['price'];
            $options['qty'] = $_POST['qty'];
            $options['description'] = $_POST['description'];

            if (\Model\Admin\Products::updateProductById($id, $options)) {

                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/{$id}.jpg");
                }
            }

            header("Location: /admin/products/index");
        }

        return true;
    }

    public function actionDelete($id) {

        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Product/DeleteProduct', ['id' => $id], true);

        if (isset($_POST['submit'])) {

            \Model\Admin\Products::deleteProductById($id);
            \Model\Admin\Products::deleteProductCategoryRelation($id);
            header("Location: /admin/products/index");
        }

        return true;
    }

}
