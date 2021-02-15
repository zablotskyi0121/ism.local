<?php

namespace Controller;

class Admin {

    public function actionLogin() {

        $email = false;
        $password = false;

        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Login', ['email' => $email, 'password' => $password,]);

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userId = \Model\Admins::checkUserData($email, $password);

            if ($userId == false) {
                echo 'Incorrect login information';
            } else {
                \Model\Admins::auth($userId);

                header("Location: /admin/cabinet");
            }
        }
    }

    public function actionCabinet() {

        session_start();
        if (isset($_SESSION["user"])) {
            $renderer = new \System\Renderer();
            $renderer = $renderer->render('Admin/Cabinet');
        } else {
            header("Location: /admin/login");
        }
    }

    public function actionLogout() {

        session_start();
        unset($_SESSION["user"]);

        header("Location: /admin/login");
    }

}
