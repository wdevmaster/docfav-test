<?php

namespace App\Application;

use App\Domain\ValueObject\Email;
use App\Domain\Repository\UserRepository;
use App\Domain\Exception\UserAlreadyExistsException;

use App\Application\PortIn\CheckUserExists as CheckUserExistsPort;

use App\Presentation\DTO\RegisterUserRequest;

class CheckUserExists implements CheckUserExistsPort
{
    public function __construct(private UserRepository $userRepository) {}

    public function execute(RegisterUserRequest $request): void
    {
        $email = new Email($request->getEmail());
        $user = $this->userRepository->findByEmail($email->getValue());

        if ($user !== null) {
            throw new UserAlreadyExistsException();
        }
    }
}