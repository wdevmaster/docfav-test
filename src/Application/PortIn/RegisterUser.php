<?php

namespace App\Application\PortIn;

use App\Presentation\DTO\RegisterUserRequest;
use App\Presentation\DTO\RegisterUserResponse;

interface RegisterUser
{
    public function execute(RegisterUserRequest $request): RegisterUserResponse;
}