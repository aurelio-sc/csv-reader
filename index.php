<?php

use CoffeeCode\Router\Router;
require_once __DIR__ . '/vendor/autoload.php';

$router = new Router("localhost/csv-reader");

$router->namespace("CsvReader\Domain\Controller");
$router->post("/add", "CsvFileController:addCsvFile", "add-csv-file");
$router->get("/view/{id}", "CsvFileController:viewCsvFile", "view-csv-file");
$router->get("/", "HomeController:index", "home");

// $router->get("/route", "Controller:method");
// $router->post("/route/{id}", "Controller:method");
// $router->put("/route/{id}/profile", "Controller:method");
// $router->patch("/route/{id}/profile/{photo}", "Controller:method");
// $router->delete("/route/{id}", "Controller:method");
$router->dispatch();