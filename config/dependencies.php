<?php

$entityManager = require __DIR__ . '/../config/doctrine.php';

// Set up Event Dispatcher and Listener Provider
// use App\Infrastructure\Service\UserRegisteredEventHandler;
// use App\Infrastructure\Service\EventDispatcher;
// $listenerProvider = new UserRegisteredEventHandler();
// $eventDispatcher = new EventDispatcher($listenerProvider);

// Set up dependencies
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
$userRepository = new DoctrineUserRepository($entityManager);

// Set up use cases
use App\Application\CheckUserExists;
use App\Application\RegisterUser;
$checkUserExistsUseCase = new CheckUserExists($userRepository);
$registerUserUseCase = new RegisterUser($userRepository, $checkUserExistsUseCase);

// Set up controllers
use App\Presentation\Controller\RegisterUserController;
$registerUserController = new RegisterUserController($registerUserUseCase);