<?php

use CsvReader\Domain\Model\CsvFile;
use CsvReader\Infrastructure\Persistence\ConnectionCreator;
use CsvReader\Infrastructure\Repository\PdoFileRepository;

require_once __DIR__ . '/vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$repository = new PdoFileRepository($pdo);

$allFiles = $repository->getAllFiles();

var_dump($allFiles);
