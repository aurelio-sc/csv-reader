<?php

namespace CsvReader\Domain\Model;

use InvalidArgumentException;

class Name
{
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
}
