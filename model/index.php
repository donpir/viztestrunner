<?php

require_once 'Executor.php';
require_once 'Task.php';
require_once 'AnswerOption.php';
require_once 'XmlParser.php';

$xml = simplexml_load_file('../experiment/experiment.xml');

$result = parse($xml);

//var_dump($result);