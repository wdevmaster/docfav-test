<?php

namespace App\Application;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Event\UserRegisteredEvent;

use App\Application\CheckUserExists;

use App\Presentation\DTO\RegisterUserRequest;
use App\Presentation\DTO\RegisterUserResponse;

use Psr\EventDispatcher\EventDispatcherInterface;

final class RegisterUser
{
    public function __construct(
        private UserRepository $userRepository, 
        private CheckUserExists $checkUserExists,
        private EventDispatcherInterface $eventDispatcher
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

        $event = new UserRegisteredEvent($user);
        $this->eventDispatcher->dispatch($event);

        return new RegisterUserResponse($user);
    }
}