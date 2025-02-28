<?php

namespace App\Application;

use App\Domain\Entity\User;
use App\Domain\Event\UserRegisteredEvent;
use App\Domain\Repository\UserRepository;

use App\Application\CheckUserExists;
use App\Application\PortIn\RegisterUser as RegisterUserPort;

use App\Presentation\DTO\RegisterUserRequest;
use App\Presentation\DTO\RegisterUserResponse;

use Psr\EventDispatcher\EventDispatcherInterface as EventDispatcher;

final class RegisterUser implements RegisterUserPort
{
    public function __construct(
        private UserRepository $userRepository, 
        private CheckUserExists $checkUserExists,
        private EventDispatcher $eventDispatcher
    ){}

    public function execute(RegisterUserRequest $request): RegisterUserResponse
    {
        $this->checkUserExists->execute($request);

        $user = User::create(
            $request->getName(),
            $request->getEmail(),
            $request->getPassword()
        );

        $this->userRepository->save($user);
        $this->eventDispatcher->dispatch(new UserRegisteredEvent($user));

        return new RegisterUserResponse($user);
    }
}