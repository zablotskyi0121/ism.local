<?php

namespace Model;

class User {

    public static function getUserId($sessionId) {
        $db = \System\Db::getInstance()->getPDO();

        $result = $db->prepare('SELECT * FROM user WHERE sessionId = :sessionId');
        $result->bindParam(':sessionId', $sessionId, \PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }
        return false;
    }

    public static function insertSession($sessionId) {

        $db = \System\Db::getInstance()->getPDO();
        $result = $db->prepare('INSERT INTO user (id, sessionId) VALUES (NULL, :sessionId)');
        $result->bindParam(':sessionId', $sessionId, \PDO::PARAM_STR);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
    }

}
