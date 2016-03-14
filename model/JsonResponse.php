<?php

class JsonResponse {

    function __construct($data) {
        $this->data = $data;
        $this->success = ($data != null);
    }//EndFunction.

    var $success = false;
    var $data = null;
    var $hasNext = false;

}//EndClass.
