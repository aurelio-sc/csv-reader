<?php

use CsvReader\Domain\Model\CsvFile;
use CsvReader\Infrastructure\Persistence\ConnectionCreator;
use CsvReader\Infrastructure\Repository\PdoFileRepository;

require_once __DIR__ . '/vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$repository = new PdoFileRepository($pdo);

$allFiles = $repository->getAllFiles();

var_dump($allFiles[0]);
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
    <details>
        <summary>Add new file</summary>
        <form method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <label for="fileName">File name</label>
                <input type="text" name="fileName" id="fileName" required>
            </div>
    
            <div class="input-field">
                <label for="csvFile">Upload CSV file</label>
                <input id="csvFile" type="file" name="csvFile" accept="text/csv">
            </div>
    
            <div class="input-field">
                <label for="delimiter">Delimiter</label>
                <input type="text" name="delimiter" id="delimiter">            
            </div>
            <div class="input-field">                
                <input type="submit" name="insertFile" id="insertFile" value="Insert">            
            </div>
        </form>
    </details>
    <table>
        <tr></tr>
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
</body>
</html>

