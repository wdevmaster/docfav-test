<?php

namespace App\Domain\Exception;

use InvalidArgumentException;

final class InvalidNameCharactersException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("Name can only contain letters and spaces.");
    }
}