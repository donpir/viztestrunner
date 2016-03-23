<?php
/**
 * Created by PhpStorm.
 * User: Donato Pirozzi
 * Date: 23/03/2016
 * Time: 16.37
 */

require_once '../model/Task.php';

$handle = fopen("UNICO_LOG.csv", "r");
$results = [];

if ($handle) {
    $result = [];

    while (($line = fgets($handle)) !== false) {
        //Process the line.
        $splitted = explode(";", $line);

        if (count($splitted) <= 7) {
            echo "Cannot split the line <i>" . $line . "</i>. The numeber of ; must be at least 7" . "<br>";
            continue;
        }

        $result[0] = $splitted[0]; //Nickname.
        $result[1] = intval($splitted[1]); //ID.

        //echo $result[0] . " # " . $result[1] .  " count: " . count($splitted) . "<br>";
        //print_r($splitted);
        //echo "<br><br>" ;

        $task = new Task();
        $task->index = intval($splitted[2]); //QuestionID.
        $task->imageUrl = $splitted[3]; //Image.
        $task->responseTime = $splitted[4]; //Response Time.
        $task->responseValue = $splitted[5]; //Answer Value.
        $task->question = $splitted[7]; //Question.

        $result[$task->index + 1] = $task;

        //echo $result[1] . "<br>";
        $results[$result[1]] = $result;
    }//EndWhile.

    fclose($handle);

} else {
    echo "Error opening the file.";
}


//WRITE THE RESULT.
$handle = fopen("output.csv", "w");
if (!$handle) {
    echo "Error in creationg the output file." . "<br>";
    return;
}

//HEADER CSV.
fwrite($handle, "nickname;");
fwrite($handle, "ID;");

for ($i=0; $i<count($results); $i++) {
    fwrite($handle, "IMAGE;");
    fwrite($handle, "Question;");
    fwrite($handle, "Answer Time;");
    fwrite($handle, "Answer Value;");
}
fwrite($handle, "\n");

//DATA.
//for ($i=0; $i<count($results); $i++) {
foreach ($results as $key => $value) {
    /*if (array_key_exists($i, $results) == false) {
        echo "Error cannot find questionnaire with ID " . $i . "<br>";
        continue;
    }*/
    $result = $value;
    $line = "";
    $line .= $result[0] . ";"; //Nickname;
    $line .= $result[1] . ";"; //ID.

    //for ($j=2; $j<count($result); $j++) {
    //Loop through user questions.
    ksort($result, SORT_NUMERIC);
    foreach ($result as $keyTask => $task) {
        /*if (array_key_exists($j, $result) == false) {
            echo $result[0] . " Missing question number " . ($j-2)  . "<br>";
            continue;
        }*/
        if ($keyTask == 0 || $keyTask == 1)
            continue;

        if ($task instanceof Task == false) {
            echo "err" . $keyTask . "<br>";
            continue;
        }

        //$task = $result[$j];
        $line .= $task->imageUrl . ";";
        $line .= $task->index . ";";
        $line .= str_replace(".", ",", $task->responseTime) . ";";
        $line .= $task->responseValue . ";";

    }//EndFor.

    $line .= "\n";
    fwrite($handle, $line);
}//EndFor.

fclose($handle);
