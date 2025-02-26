<?php

namespace App\Domain\Exception;

use InvalidArgumentException;

final class InvalidNameLengthException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("Name must be at least 3 characters long.");
    }
}