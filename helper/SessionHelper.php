<?php

require_once 'SessionData.php';

class SessionHelper {

    var $SESSIONKEY = 'USER_DATA';

    function clean() {
        $_SESSION[$this->SESSIONKEY] = null;
    }

    function getInstance() {
        $session =  $_SESSION[$this->SESSIONKEY];
        if ($session == null) {
            $session = new SessionData();
            $_SESSION[$this->SESSIONKEY] = $session;
        }

        return $session;
    }

}//EndClass.


