<?php

namespace App\Application;

use App\Domain\Repository\UserRepository;
use App\Domain\ValueObject\Email;
use App\Domain\Exception\UserAlreadyExistsException;

use App\Presentation\DTO\RegisterUserRequest;

final class CheckUserExists
{
    public function __construct(
        private UserRepository $userRepository
    ){}

    public function execute(RegisterUserRequest $request): void
    {
        $email = new Email($request->getEmail());

        if ($this->userRepository->findByEmail($email->getValue())) {
            throw new UserAlreadyExistsException();
        }
    }
}