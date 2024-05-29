<?php

namespace CsvReader\Domain\Controller;

use CsvReader\Domain\Model\CsvFile;
use CsvReader\Domain\Model\Delimiter;
use CsvReader\Domain\Model\Name;
use CsvReader\Domain\Repository\FileRepository;
use CsvReader\Infrastructure\Persistence\ConnectionCreator;
use CsvReader\Infrastructure\Repository\PdoFileRepository;
use Exception;

class CsvFileController
{
    private FileRepository $fileRepository;
    private CsvFile $csvFile;
    public function addCsvFile(): void
    {
        if($_FILES['csvFile']['error'] == UPLOAD_ERR_OK) {            
            if($this->checkCsvExtension($_FILES['csvFile'])){
                $delimiter = $_POST['delimiter'];
                $name = $_POST['fileName'] ? : $_FILES['csvFile']['name'];
                try {
                    $this->csvFile = new CsvFile(new Name($name), new Delimiter($delimiter));                    
                } catch (Exception $e) {
                    $error = new ErrorLog($e->getMessage());
                }
            }
            
        }
    }

    public function checkCsvExtension($file): bool
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($extension !== 'csv') {
            return false;
        }
        return true;
    }
}