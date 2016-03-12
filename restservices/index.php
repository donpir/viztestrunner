<?php

require '../vendor/autoload.php';
require_once '../model/Executor.php';
require_once '../model/Task.php';
require_once '../model/AnswerOption.php';
require_once '../model/XmlParser.php';

$app = new Slim\App();

$app->get('/', function ($request, $response, $args) {
});

$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');

$app->get('/loadnext/{index}', function ($request, $response, $args) {

    $xml = simplexml_load_file('../experiment/experiment.xml');

    $result = parse($xml);

    $index = intval( $args['index'] );
    $toJson = new JsonResponse($result->tasks[$index], $index < count($result->tasks) - 1);

    header("Content-Type: application/json");
    $response->write( json_encode($toJson) );
    return $response;
});

$app->run();
