<?php
    // Start the session
    require_once '../helper/SessionHelper.php';
?>

<?php


    $keyNickname = 'nickname';
    $keyExpCounter = 'counter';

    if (array_key_exists($keyNickname, $_POST) == false || array_key_exists($keyExpCounter, $_POST) == false) {
        print("Insert the nickname and the experiment id");
        die();
    }

    $nickname = $_POST[$keyNickname];
    $expcounter = $_POST[$keyExpCounter];

    if (strlen(trim($nickname)) == 0 || strlen(trim($expcounter) == 0)) {
        print("Invalid nickname or invalid experiment id" . "<br>");
        print("Nickname: " . $nickname . "<br>");
        print("Experiment ID: " . $expcounter . "<br>");
        die();
    }

    $expcounter = intval($expcounter);

    if ($expcounter < 0) {
        print("Invalid experiment id");
        die();
    }

    //Parameters are ok!!!
    SessionHelper::clean();
    $sessiondata = SessionHelper::getInstance();
    $sessiondata->nickname = $nickname;
    $sessiondata->id = $expcounter;

    header('Location: Question.php');
    die();
