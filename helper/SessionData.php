<?php

class SessionData {

    var $nickname;
    var $id;
    var $tasks = [];
    var $tasksOriginal = [];

    var $indexLastQuestion = null;
    var $timeLastRequest = null;

    function buildCSVRow() {
        $csv = 'nickname;' . 'id;';

        foreach ($this->tasks as $task) {
            $csv .= 'qid' . $task.index . ';';
            $csv .= $task.response . ';';
            $csv .= $task.time . ';';
        }//EndFor.

        return $csv;
    }//EndFunction.

}//EndClass.