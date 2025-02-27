<?php

namespace App\Presentation\Controller;

use App\Application\PortIn\RegisterUser as RegisterUserPort;

use App\Infrastructure\Exception\ExceptionHandler;

use App\Presentation\DTO\RegisterUserRequest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegisterUserController
{
    public function __construct(
        private RegisterUserPort $registerUser,
        private ExceptionHandler $exceptionHandler
    ){}

    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $registerUserRequest = new RegisterUserRequest(
            $data['name'],
            $data['email'],
            $data['password']
        );

        try {
            $response = $this->registerUser->execute($registerUserRequest);

            $responseData = [
                'id' => $response->getId(),
                'name' => $response->getName(),
                'email' => $response->getEmail(),
                'createdAt' => $response->getCreatedAt()
            ];

            return new JsonResponse($responseData, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return $this->exceptionHandler->handle($e);
        }
        
    }
}