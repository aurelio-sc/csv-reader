<?php

namespace CsvReader\Domain\Model;

use InvalidArgumentException;

class Name
{
    private string $value;

    public function __construct(string $value)
    {
        self::validateName($value);
        $this->value = $value;
    }

    public static function validateName(string $name): bool
    {
        if (strlen($name) > 255) {
            throw new InvalidArgumentException('Name is too long');
        }

        if (strlen($name) < 3) {
            throw new InvalidArgumentException('Name is too short');
        }

        return true;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
