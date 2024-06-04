<?php

namespace CsvReader\Domain\Controller;

use DateTimeImmutable;

class ErrorLog
{
    private string $error;
    private DateTimeImmutable $errorDate;
    private string $errorMessage;
    private string $errorFile;
    public function __construct(string $error, $file = PATHS['src'] . '/errorLog.txt')
    {
        $this->error = $error;
        $this->errorDate = new DateTimeImmutable();        
        $this->errorFile = $file;        
        $this->setErrorMessage();        
    }

    private function setErrorMessage()
    {
        $this->errorMessage = '[' . $this->errorDate->format('Y-m-d H:i:s') . '] - ' . $this->error . PHP_EOL;        
    }

    public function logError()
    {
        error_log($this->errorMessage, 3, $this->errorFile);
    }
}