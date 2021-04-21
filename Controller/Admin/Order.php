<?php

namespace Controller\Admin;

class Order {

    public function actionIndex() {

        $orderList = \Model\Admin\Order::getOrdersList();
        \System\Renderer::render('Admin/Order/List', ['orderList' => $orderList], true);
    }

    public function actionUpdate($id) {
        
        $order = \Model\Admin\Order::getOrderById($id);
        $productList = \Model\Admin\Order::getProductsPerOrder($id);
        
        \System\Renderer::render('Admin/Order/Update', ['order' => $order, 'productList' => $productList], true);
    }

}
