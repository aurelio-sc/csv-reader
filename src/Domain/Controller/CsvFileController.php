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
                $name = $_POST['fileName'] ? : $_FILES['csvFile']['name'];
                try {
                    if (!empty($_POST['delimiter'])) {
                        $delimiter = $_POST['delimiter'];
                        $this->csvFile = new CsvFile(new Name($name), new Delimiter($delimiter));
                    } else {
                        $this->csvFile = new CsvFile(new Name($name));
                    }                   
                    move_uploaded_file($_FILES['csvFile']['tmp_name'], PATHS['uploads'] . '/' . $this->csvFile->getName());
                    $this->fileRepository = new PdoFileRepository(ConnectionCreator::createConnection());
                    $this->fileRepository->save($this->csvFile);           
                    header('Location: index.php');
                } catch (Exception $e) {
                    $error = new ErrorLog($e->getMessage());
                    $error->logError();
                }
            }            
        }
    }

    public function viewCsvFile(array $params): void
    {   
        print_r($params);        
        if ($id = $params['id']) {
            $this->fileRepository = new PdoFileRepository(ConnectionCreator::createConnection());
            $csvFile = $this->fileRepository->getFile($id);
            $view = require PATHS['views'] . '/viewCsvFile.php';            
            echo $view;            
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