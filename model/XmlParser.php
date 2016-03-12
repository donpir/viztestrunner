<?php

function parse($xml) {

    $executor = new Executor();
    $execution = $xml->testrunner->execution;
    foreach ($execution->execute as $i => $itemExecution) {//Loop through Executions.
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
    $templates = $xml->templates;

    foreach ($templates->template as $key => $template) {//Loop through templates.
        $templateAttrs = $template->attributes();

//        print_r($templateAttrs["id"] . " #  " . $templateId . " # ");
//        print_r(strcmp($templateAttrs["id"], $templateId));
//        echo "<BR>";
//        echo "<BR>";

        $test = strcmp($templateAttrs["id"], $templateId);
        if ($test == 0) {
            $tasks = [];

            foreach ($template->task as $i => $tempTask) {//Loop through TASKS.
                $task = new Task();
                $task->imageUrl = (string) $execAttrs["image"];
                $task->question = $tempTask->question->asXml();
                $task->answerType = (string) $tempTask->answer->attributes()["type"];
                $task->answerOptions = parseAnswerOptions($tempTask);

                $task->valueFrom = (string) $tempTask->answer->attributes()["valueFrom"];
                $task->valueTo = (string) $tempTask->answer->attributes()["valueTo"];
                $task->labelFrom = (string) $tempTask->answer->attributes()["labelFrom"];
                $task->labelTo = (string) $tempTask->answer->attributes()["labelTo"];

                array_push($tasks, $task);
            }
            return $tasks;
        }//EndIf.
    }//EndFor.

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