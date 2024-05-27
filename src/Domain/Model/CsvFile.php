<?php

namespace CsvReader\Domain\Model;

class CsvFile
{
    private ?int $id = null;
    private string $name;
    private string $delimiter;

    public function __construct(string $name, string $delimiter = ',')
    {
        Name::validateName($name);
        Delimiter::validateDelimiter($delimiter);
        
        $this->name = $name;
        $this->delimiter = $delimiter;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setDelimiter(string $delimiter): void
    {
        $this->delimiter = $delimiter;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}