<?php

namespace App\Domain\Exception;

use Exception;

final class UserAlreadyExistsException extends Exception
{
    public function __construct()
    {
        parent::__construct("A user with this email already exists.");
    }
}