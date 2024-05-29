<?php

use CsvReader\Domain\Model\CsvFile;
use CsvReader\Infrastructure\Persistence\ConnectionCreator;
use CsvReader\Infrastructure\Repository\PdoFileRepository;
use CoffeeCode\Router\Router;

require_once __DIR__ . '/vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$repository = new PdoFileRepository($pdo);

$allFiles = $repository->getAllFiles();

//var_dump($allFiles[0]);


$router = new Router("localhost/csv-reader");

$router->namespace("CsvReader\Domain\Controller");
$router->post("/add", "CsvFileController:addCsvFile", "add-csv-file");

// $router->get("/route", "Controller:method");
// $router->post("/route/{id}", "Controller:method");
// $router->put("/route/{id}/profile", "Controller:method");
// $router->patch("/route/{id}/profile/{photo}", "Controller:method");
// $router->delete("/route/{id}", "Controller:method");
$router->dispatch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style/reset.css">
    <link rel="stylesheet" href="src/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <title>CSV Reader</title>
</head>
<body>
    <section class="container container-two-columns">
        <details>
            <summary>Add new file</summary>
            <form action="add" method="POST" enctype="multipart/form-data">
                <fieldset class="input-field">
                    <legend>File name</legend>                
                    <input type="text" name="fileName" id="fileName">
                </fieldset>
        
                <filedset class="input-field">
                    <legend>Upload CSV file</legend>
                    <label class="file-label" for="csvFile">Choose file</label>
                    <input id="csvFile" type="file" name="csvFile" accept="text/csv">
                </filedset>
        
                <fieldset class="input-field">
                    <legend>Delimiter</legend>
                    <input type="text" name="delimiter" id="delimiter">            
                </fieldset>
                <input class="submit" type="submit" name="insertFile" id="insertFile" value="Add file"> 
            </form>
        </details>
        <table class="table-two-columns" id="file-list">            
                <th>Name</th>
                <th>Delimiter</th>
            </tr>
            <?php foreach ($allFiles as $file) { ?>
            <tr>
                <td><?= $file->getName() ?></td>
                <td><?= $file->getDelimiter() ?></td>
            </tr>
            <?php } ?>
        </table>  
    </section>    
</body>
</html>

