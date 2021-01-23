<?php

namespace Model;

class User {

    public static function checkLogged() {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /admin/login");
    }

    public static function getUserById($id) {
        $_instance = \System\Db::getInstance()->getInstance();

        $sql = $_instance->query('SELECT * FROM Ism.users WHERE id = :id');

        $result = $_instance->prepare($sql);
        $result->bindParam(':id', $id, \PDO::PARAM_INT);

        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
        
    }

    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public static function checkPassword($password) {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    public static function checkUserData($email, $password) {

        $_instance = \System\Db::getInstance()->getInstance();

        $sql = $_instance->query('SELECT * FROM Ism.users WHERE email = :email AND password = :password');

        $result = $_instance->prepare($sql);
        $result->bindParam(':email', $email, \PDO::PARAM_INT);
        $result->bindParam(':password', $password, \PDO::PARAM_INT);
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
