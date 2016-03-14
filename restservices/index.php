<?php

require '../vendor/autoload.php';
require_once '../model/Executor.php';
require_once '../model/Task.php';
require_once '../model/AnswerOption.php';
require_once '../model/XmlParser.php';
require_once '../model/JsonResponse.php';

require_once 'CSVFileWriter.php';

$app = new Slim\App();

$app->get('/', function ($request, $response, $args) {
});

$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');

$app->get('/save', function($request, $response, $args) {
    return $response;
});

$app->get('/loadnext/{index}', function ($request, $response, $args) {

    $xml = simplexml_load_file('../experiment/experiment.xml');

    $result = parse($xml);

    $index = intval( $args['index'] );
    $toJson = (new JsonResponse)->success($result->tasks[$index]);
    $toJson->hasNext = $index < count($result->tasks) - 1;

    try {
        $writer = new CSVFileWriter('../experiment/log.csv');

        $bwrote = $writer->write(null);
        if ($bwrote === FALSE) {
            $toJson->fail(error_get_last()['message']);
        }

    } catch (Exception$e) {
        $toJson->fail($e->getMessage());
    }

    header("Content-Type: application/json");
    $response->write( json_encode($toJson) );
    return $response;
});

$app->run();
