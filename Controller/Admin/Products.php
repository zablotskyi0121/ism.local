<?php

namespace Controller\Admin;

class Products {

    public function actionIndex() {

        $productList = \Model\Product::getAllProduct();
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/ProductList', ['productList' => $productList]);
    }

    public function actionCreate() {

        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/CreateProduct');

        if (isset($_POST['submit'])) {

            $options['name'] = $_POST['name'];
            $options['price'] = $_POST['price'];
            $options['qty'] = $_POST['qty'];
            $options['sku'] = $_POST['sku'];
            $options['description'] = $_POST['description'];

            $id = \Model\Product::createProduct($options);

            if ($id) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/{$id}.jpg");
                }
            };

            header("Location: /products/index");
        }

        return true;
    }

    public function actionUpdate($id) {

        $product = \Model\Product::getProductById($id);

        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/UpdateProduct', ['id' => $id, 'product' => $product]);

        if (isset($_POST['submit'])) {

            $options['name'] = $_POST['name'];
            $options['sku'] = $_POST['sku'];
            $options['price'] = $_POST['price'];
            $options['qty'] = $_POST['qty'];
            $options['description'] = $_POST['description'];

            if (\Model\Product::updateProductById($id, $options)) {

                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                    move_uploaded_file($_FILES["image"]["tmp_name"], _DIR_PUB_ . "/media/images/{$id}.jpg");
                }
            }

            header("Location: /products/index");
        }

        return true;
    }

    public function actionDelete($id) {

        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/DeleteProduct', ['id' => $id]);

        if (isset($_POST['submit'])) {

            \Model\Product::deleteProductById($id);

            header("Location: /products/index");
        }

        return true;
    }

}
