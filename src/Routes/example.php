<?php
use \MyApp\Models;

$router->respond('GET', '/', function($request, $response, $service, $app) {
    $id = $request->param('id');

    $one = Models\ExampleModel::findOne($id);
    $many = Models\ExampleModel::findMany();

    return $app->twig->render('index.html.twig', [
        'record' => $one,
        'many_records' => $many
    ]);
});

$router->respond('GET', '/index', function($request, $response, $service, $app) {
    return $app->redirect('/');
});