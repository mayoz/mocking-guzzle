<?php

include 'vendor/autoload.php';

use App\TodoService;

$service = new TodoService;

$todo = $service->find(1);

$response = json_decode($todo->getBody()->getContents(), true);

var_dump($response);
