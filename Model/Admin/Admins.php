<?php

namespace Model\Admin;

class Admins {

     public static function getUserById($id) {
        $db = \System\Db::getInstance()->getInstance();

        $result = $db->prepare('SELECT * FROM admins WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);

        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    public static function checkUserData($email, $password) {

        $db = \System\Db::getInstance()->getInstance();

        $result = $db->prepare('SELECT * FROM admins WHERE email = :email AND password = :password');
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

        session_start();
        $_SESSION['user'] = $userId;
    }

}
