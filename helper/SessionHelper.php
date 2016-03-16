<?php

require_once 'SessionData.php';
require_once '../model/Task.php';
session_start();

class SessionHelper {

    public static $SESSIONKEY = 'USER_DATA';
    private static $session = null;

    static function clean() {
        unset($_SESSION[self::$SESSIONKEY]);
        self::$session = null;
    }

    static function getInstance() {
        if (isset($_SESSION[self::$SESSIONKEY])) {
            self::$session = $_SESSION[self::$SESSIONKEY];
        } else {
            self::$session = new SessionData();
            $_SESSION[self::$SESSIONKEY] = self::$session;
        }

        return self::$session;
    }//

}//EndClass.


