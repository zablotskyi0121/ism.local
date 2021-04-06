<?php

namespace Controller;

class Home {

    public function actionHome() {

        \System\Renderer::render('Home');
    }

}
