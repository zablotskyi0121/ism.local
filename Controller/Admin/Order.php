<?php

namespace Controller\Admin;

class Order {

    public function actionIndex() {

        $orderList = \Model\Admin\Order::getOrdersList();
        \System\Renderer::render('Admin/Order/List', ['orderList' => $orderList], true);
    }

}
