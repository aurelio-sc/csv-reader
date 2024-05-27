<?php

namespace CsvReader\Domain\Repository;

use CsvReader\Domain\Model\CsvFile;

interface FileRepository
{
    public function getAllFiles(): array;

    public function save(CsvFile $file): bool;

    public function remove(CsvFile $file): bool;
}