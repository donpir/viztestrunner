<?php
/**
 * Created by PhpStorm.
 * User: Donato Pirozzi
 * Date: 14/03/2016
 * Time: 11.00
 */

class CSVFileWriter {

    var $filename;

    function __construct($filename) {
        $this->filename = $filename;
    }//EndConstructor.

    function write($arr) {
        $current = "ciccio";
        return file_put_contents($this->filename, $current, FILE_APPEND);
    }//EndFunction.

}//EndClass.