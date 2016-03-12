<?php

class JsonResponse {

    function __construct($data) {
        this.$data = $data;
        if ($data != null)
            this.$success = true;
    }//EndFunction.

    var $success = false;
    var $data = null;
    var $hasNext = false;

}//EndClass.
