<?php

namespace App\Domain\Exception;

use InvalidArgumentException;

final class InvalidDateFormatException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("Invalid date format, expected 'Y-m-d H:i:s'.");
    }
}