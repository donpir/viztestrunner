<?php

function parse($xml) {
    $executor = new Executor();
    $arrExecution = $xml->testrunner->execution->execute;
    foreach ($arrExecution as $i => $itemExecution) {
        $tempId = (string) $itemExecution->attributes()["template"];
        $tasks = findAndParseTemplate($xml, $itemExecution, $tempId);
        if ($tasks != null)
            foreach ($tasks as $i => $task)
                array_push($executor->tasks, $task);
    }
    return $executor;
}//EndFunction.

function findAndParseTemplate($xml, $execution, $templateId) {
    $execAttrs = $execution->attributes();

    $template = $xml->templates->template; //TODO: Change this.
    $templateAttrs = $template->attributes();

    if (strcmp($templateAttrs["id"], $templateId) == 0) {
        $tasks = [];
        $tempTasks = $template->task;
        foreach ($tempTasks as $i => $tempTask) {//Loop through TASKS.
            $task = new Task();
            $task->imageUrl = (string) $execAttrs["image"];
            $task->question = $tempTask->question->asXml();
            $task->answerType = (string) $tempTask->answer->attributes()["type"];
            $task->answerOptions = parseAnswerOptions($tempTask);
            array_push($tasks, $task);
        }
        return $tasks;
    }

    return null;
}//EndFunction.

function parseAnswerOptions($tempTask) {
    $options = [];
    foreach ($tempTask->answer->option as $j => $tempTaskOption) {
        $option = new AnswerOption();
        $option->label = (string) $tempTaskOption->attributes()["label"];

        $attrType = (string) $tempTaskOption->attributes()["type"];
        $option->type = $attrType != null ? $attrType : null;

        array_push($options, $option);
    }
    return $options;
}//EndFunction.