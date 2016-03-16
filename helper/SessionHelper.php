<?php

require_once 'SessionData.php';
require_once '../model/Task.php';
session_start();

class SessionHelper {

    public static $SESSIONKEY = 'USER_DATA';

    static function clean() {
        unset($_SESSION[self::$SESSIONKEY]);
    }

    static function getInstance() {
        if (isset($_SESSION[self::$SESSIONKEY])) {
            $session = $_SESSION[self::$SESSIONKEY];
        } else {
            $session = new SessionData();
            $_SESSION[self::$SESSIONKEY] = $session;
        }

        return $session;
    }

}//EndClass.


