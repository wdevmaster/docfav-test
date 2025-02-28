<?php

namespace App\Application\PortIn;

use App\Presentation\DTO\RegisterUserRequest;

interface CheckUserExists
{
    public function execute(RegisterUserRequest $request): void;
}