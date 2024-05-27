<?php

namespace CsvReader\Domain\Model;

use InvalidArgumentException;

class Delimiter
{
    public static function validateDelimiter(string $delimiter): bool
    {
        if (strlen($delimiter) != 1) {
            return new InvalidArgumentException('Delimiter must be a single character.');
        }

        return true;
    }
}
