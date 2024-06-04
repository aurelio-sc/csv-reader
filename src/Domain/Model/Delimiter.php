<?php

namespace CsvReader\Domain\Model;

use InvalidArgumentException;

class Delimiter
{
    private string $value;

    public function __construct(string $value)
    {
        self::validateDelimiter($value);
        $this->value = $value;
    }

    public static function validateDelimiter(string $delimiter): bool
    {
        if (strlen($delimiter) != 1) {
            throw new InvalidArgumentException('Delimiter must be a single character.');
        }

        return true;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
