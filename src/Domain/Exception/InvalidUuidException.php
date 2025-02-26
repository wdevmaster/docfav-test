<?php

namespace App\Domain\Exception;

use InvalidArgumentException;

final class InvalidUuidException extends InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct("Invalid UUID string: $message");
    }
}