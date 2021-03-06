<?php

function parse($xml) {

    $executor = new Executor();
    $execution = $xml->testrunner->execution;
    foreach ($execution->execute as $i => $itemExecution) {//Loop through Executions.
        $tempId = (string) $itemExecution->attributes()["template"];
        $tasks = findAndParseTemplate($xml, $itemExecution, $tempId);
        if ($tasks != null)
            foreach ($tasks as $i => $task) {
                $numofitems = array_push($executor->tasks, $task);
                $task->index = $numofitems;
            }//EndForEach.
    }
    return $executor;
}//EndFunction.

function findAndParseTemplate($xml, $execution, $templateId) {
    $execAttrs = $execution->attributes();
    $templates = $xml->templates;

    foreach ($templates->template as $key => $template) {//Loop through templates.
        $templateAttrs = $template->attributes();

        $test = strcmp($templateAttrs["id"], $templateId);
        if ($test == 0) {
            $tasks = [];

            foreach ($template->task as $i => $tempTask) {//Loop through TASKS.
                $task = new Task();
                $task->imageUrl = (string) $execAttrs["image"];
                $task->question = (string) $tempTask->question;

                $task->answerType = (string) $tempTask->answer->attributes()["type"];

                $task->valueFrom = (string) $tempTask->answer->attributes()["valueFrom"];
                $task->valueTo = (string) $tempTask->answer->attributes()["valueTo"];
                $task->labelFrom = (string) $tempTask->answer->attributes()["labelFrom"];
                $task->labelTo = (string) $tempTask->answer->attributes()["labelTo"];

                $task->answerOptions = parseAnswerOptions($task, $tempTask);

                array_push($tasks, $task);
            }
            return $tasks;
        }//EndIf.
    }//EndFor.

    return null;
}//EndFunction.

function parseAnswerOptions($taskInstance, $tempTask) {
    $options = [];

    if (strcmp($taskInstance->answerType, 'range') == 0) {
        for ($i=$taskInstance->valueFrom; $i <=$taskInstance->valueTo; $i++) {
            $ansOpt = new AnswerOption();
            $ansOpt->label = $i . "";
            $ansOpt->name = "qid" . $tempTask->index . "_" . $ansOpt->label;
            array_push($options, $ansOpt);
        }

        return $options;
    }

    foreach ($tempTask->answer->option as $j => $tempTaskOption) {
        $option = new AnswerOption();
        $option->label = (string) $tempTaskOption->attributes()["label"];
        $option->name = "qid" . $tempTask->index . "_" . $option->label;

        $attrType = (string) $tempTaskOption->attributes()["type"];
        $option->type = $attrType != null ? $attrType : null;

        array_push($options, $option);
    }
    return $options;
}//EndFunction.