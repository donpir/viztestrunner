<?php

require '../vendor/autoload.php';

require_once '../model/Executor.php';
require_once '../model/AnswerOption.php';
require_once '../model/XmlParser.php';
require_once '../model/JsonResponse.php';

require_once '../helper/SessionHelper.php';
require_once '../helper/SessionData.php';
require_once '../model/Task.php';


require_once 'CSVFileWriter.php';

$app = new Slim\App();

$app->get('/', function ($request, $response, $args) {
});

$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');

$app->post('/save', function($request, $response, $args) {
    $jsonResponse = new JsonResponse();
    $jsonResponse->success = true;

    //Get the request body.
    $body = $request->getBody();
    $jsonBody = json_decode($body, true);
    if ($jsonBody == null)
        $jsonResponse->fail("Invalid request.");

    //Access to session data.
    $sessiondata = SessionHelper::getInstance();
    if ($sessiondata == null)
        $jsonResponse->fail("There is nothing in the Session about this test.");
    if ($sessiondata->indexLastQuestion == null)
        $jsonResponse->fail("Cannot determine the index of the last question");

    //print_r();

    if ($jsonResponse->success) {
        $pIndex = $jsonBody["question"]["index"];
        $pResponse = $jsonBody["question"]["response"];
        $pOther = array_key_exists("other", $jsonBody["question"]) ? $jsonBody["question"]["other"] : null;

        $task = $sessiondata->tasks[$pIndex];
        $task->responseTime = $sessiondata->timeLastRequest - microtime(true);
        $task->responseValue = $pResponse;
        $task->responseOther = $pOther;//property_exists($jsonBody.question, "other") ? $jsonBody.question.other : null;

        $jsonResponse->hasNext = $pIndex < count($sessiondata->tasks) - 1;

        //It writes the data within the csv file.
        try {
            $writer = new CSVFileWriter('../experiment/log.csv');

            $arr = [];
            array_push($arr, $sessiondata->nickname . ";");
            array_push($arr, $sessiondata->id . ";");
            array_push($arr, $task->$pIndex . ";");
            array_push($arr, $task->$imageUrl . ";");
            array_push($arr, $task->responseTime . ";");
            array_push($arr, $task->responseValue . ";");
            array_push($arr, $task->responseOther . ";");
            array_push($arr, $task->question . ";");

            $bwrote = $writer->write(null);
            if ($bwrote === FALSE) {
                $jsonResponse->fail(error_get_last()['message']);
            }

        } catch (Exception$e) {
            $jsonResponse->fail($e->getMessage());
        }
    }

    $response->write(json_encode($jsonResponse));
    header("Content-Type: application/json");
    return $response;
});

$app->get('/loadnext/{index}', function ($request, $response, $args) {

    $xml = simplexml_load_file('../experiment/experiment.xml');

    $result = parse($xml);

    $index = intval( $args['index'] );
    $toJson = (new JsonResponse)->success($result->tasks[$index]);
    $toJson->hasNext = $index < count($result->tasks) - 1;

    //Access to session data.
    $sessiondata = SessionHelper::getInstance();
    $sessiondata->timeLastRequest = microtime(true);
    $sessiondata->indexLastQuestion = $index;
    if ($sessiondata->tasks == null)
        $sessiondata->tasks = $result->tasks;

    header("Content-Type: application/json");
    $response->write( json_encode($toJson) );
    return $response;
});

$app->run();
