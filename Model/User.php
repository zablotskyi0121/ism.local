<?php
namespace Model;

session_start();


class User {

    public static function checkLogged() {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /admin/login");
    }

    public static function getUserById($id) {
        $db = \System\Db::getInstance();

        $result = $db->prepare('SELECT * FROM users WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);

        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    public static function checkUserData($email, $password) {

        $db = \System\Db::getInstance();

        $result = $db->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
        $result->bindParam(':email', $email, \PDO::PARAM_STR);
        $result->bindParam(':password', $password, \PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();

        if ($user) {
            return $user['id'];
        }
        return false;
    }

    public static function auth($userId) {
        $_SESSION['user'] = $userId;
    }

}
