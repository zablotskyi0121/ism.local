<?php

namespace Controller\Admin;

class Cabinet {

    public function actionLogin() {

        $email = false;
        $password = false;
        \System\Renderer::render('Admin/Login', ['email' => $email, 'password' => $password], true);
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);

            $userId = \Model\Admin\Admins::checkUserData($email, $password);

            if ($userId == false) {
                echo '<div style="color:#F00; text-align:center; top:15%; position:absolute;">The account login was incorrect. Check your credential.';
            } else {
                \Model\Admin\Admins::auth($userId);

                header("Location: /admin/cabinet/cabinet");
            }
        }
    }

    public function actionCabinet() {

        if (isset($_SESSION["user"])) {
            \System\Renderer::render('Admin/Cabinet', [], true);
        } else {
            header("Location: /admin/cabinet/login");
        }
    }

    public function actionLogout() {

        unset($_SESSION["user"]);

        header("Location: /admin/cabinet/login");
    }

}
