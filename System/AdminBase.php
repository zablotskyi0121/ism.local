<?php

namespace System;

/**
 * Description of adminBase
 *
 * @author zablotskyi
 */
abstract class AdminBase {

    public static function checkAdmin() {
        $userId = \Model\User::checkLogged();
        $user = \Model\User::getUserById($userId);        
        if ($user['admin'] == 1) {
            return true;
        }
        die('Access denied');
    }

}
