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
        $content = "";
        foreach ($arr as $value)
            $content .= $value . ";";
        $content .= "\n";

        return file_put_contents($this->filename, $content, FILE_APPEND);
    }//EndFunction.

}//EndClass.