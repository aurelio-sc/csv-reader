<?php

namespace CsvReader\Domain\Controller;

use CsvReader\Domain\Model\CsvFile;
use CsvReader\Infrastructure\Persistence\ConnectionCreator;
use CsvReader\Infrastructure\Repository\PdoFileRepository;



class HomeController
{
    public function index(): void
    {
        $pdo = ConnectionCreator::createConnection();
        $repository = new PdoFileRepository($pdo);
        $allFiles = $repository->getAllFiles();
        $view = require PATHS['views'] . '/home.php';
        echo $view;
    }
}