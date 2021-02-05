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

            $errors = false;

            if (!\Model\User::checkEmail($email)) {
                $errors[] = 'Wrong email';
            }
            if (!\Model\User::checkPassword($password)) {
                $errors[] = 'Password must be more than 6 characters.';
            }

            $userId = \Model\User::checkUserData($email, $password);

            if ($userId == false) {
                $errors[] = 'Incorrect login information';
            } else {
                \Model\User::auth($userId);

                header("Location: /admin/cabinet");
            }
        }
    }

    public function actionCabinet() {
        $renderer = new \System\Renderer();
        $renderer = $renderer->render('Admin/Cabinet');
    }

}
