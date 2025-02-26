<?php

namespace App\Domain\Exception;

use InvalidArgumentException;

final class InvalidEmailException extends InvalidArgumentException
{
    public function __construct(string $value)
    {
        parent::__construct(sprintf('"%s" is not a valid email address.', $value));
    }
}