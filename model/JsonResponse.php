<?php

class JsonResponse {

    /*function __construct($data) {
        $this->data = $data;
        $this->success = ($data != null);
    }//EndFunction.*/

    function success($data) {
        $this->data = $data;
        $this->success = ($data != null);
        return $this;
    }//EndFunction.

    function fail($message) {
        $this->errMessage = $message;
        $this->success = false;
        return $this;
    }//EndFunction.

    var $success = false;
    var $data = null;
    var $hasNext = false;
    var $errMessage = "";

}//EndClass.
