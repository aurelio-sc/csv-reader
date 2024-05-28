<?php

namespace CsvReader\Domain\Model;

class CsvFile
{
    private ?int $id = null;
    private Name $name;
    private Delimiter $delimiter;

    public function __construct(Name $name, Delimiter $delimiter = new Delimiter(','))
    {               
        $this->name = $name;
        $this->delimiter = $delimiter;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name->getValue();
    }
    
    public function getDelimiter(): string
    {
        return $this->delimiter->getValue();
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setDelimiter(Delimiter $delimiter): void
    {
        $this->delimiter = $delimiter;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }
}