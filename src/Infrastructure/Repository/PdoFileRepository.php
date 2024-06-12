<?php

namespace CsvReader\Infrastructure\Repository;

use CsvReader\Domain\Model\CsvFile;
use CsvReader\Domain\Model\Delimiter;
use CsvReader\Domain\Model\Name;
use CsvReader\Domain\Repository\FileRepository;
use Exception;
use PDO;
use PDOStatement;

class PdoFileRepository implements FileRepository
{
    private PDO $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getAllFiles(): array
    {
        $query = 'SELECT * FROM csv_file';
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $this->hydrateFileList($statement);
    }

    public function getFile(int $id): array
    {
        $query = 'SELECT * FROM csv_file WHERE id = :id';
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        
        if ($statement->rowCount() === 0) {
            throw new Exception('File not found');
        }
        return $this->hydrateFileList($statement);
    }

    public function hydrateFileList(PDOStatement $statement):array
    {
        $fileDataList = $statement->fetchAll();
        $fileList = [];
        
        foreach ($fileDataList as $fileData) {
            $file = new CsvFile(                
                new Name($fileData['name']),
                new Delimiter($fileData['delimiter'])
                );
            $file->setId($fileData['id']);
            
            $fileList[] = $file;
        }

        return $fileList;
    }

    public function save(CsvFile $csvFile): bool
    {
        if (!$this->checkNameAvailability($csvFile)) {
            throw new Exception('Name already in use');
        }
        if ($csvFile->getId() === null) {
            return $this->insert($csvFile);
        }
        return $this->update($csvFile);      
    }

    private function insert(CsvFile $csvFile): bool
    {
        $query = 'INSERT into csv_file (name, delimiter) values (:name, :delimiter)';
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':name', $csvFile->getName());
        $statement->bindValue(':delimiter', $csvFile->getDelimiter());
        
        $result = $statement->execute();

        if ($result) {
            $csvFile->setId((int) $this->connection->lastInsertId());
        }

        return $result;
    }

    private function update(CsvFile $csvFile): bool
    {
        $query = 'UPDATE csv_file SET name = :name, delimiter = :delimiter WHERE id = :id';
        $statement = $this->connection->prepare($query);        
        $statement->bindValue(':name', $csvFile->getName());
        $statement->bindValue(':delimiter', $csvFile->getDelimiter());
        $statement->bindValue(':id', $csvFile->getId(), PDO::PARAM_INT);
        
        return $statement->execute();
    }
    

    public function remove(CsvFile $csvFile): bool
    {
        $query = 'DELETE FROM csv_file WHERE id = :id';
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $csvFile->getId(), PDO::PARAM_INT);
        
        return $statement->execute();
    }

    private function checkNameAvailability(CsvFile $csvFile): bool
    {
        $query = 'SELECT * FROM csv_file WHERE name = :name';
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':name', $csvFile->getName());
        $statement->execute();
        
        return $statement->rowCount() === 0;
    }
}