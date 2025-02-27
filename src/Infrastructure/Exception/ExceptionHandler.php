<?php

namespace App\Infrastructure\Exception;

use App\Domain\Exception\InvalidUuidException;
use App\Domain\Exception\InvalidNameCharactersException;
use App\Domain\Exception\InvalidNameLengthException;
use App\Domain\Exception\InvalidEmailException;
use App\Domain\Exception\WeakPasswordException;
use App\Domain\Exception\InvalidDateFormatException;
use App\Domain\Exception\UserAlreadyExistsException;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

final class ExceptionHandler
{
    public function handle(Throwable $exception): Response
    {
        $exceptionMapping = [
            InvalidUuidException::class => Response::HTTP_BAD_REQUEST,
            InvalidNameCharactersException::class => Response::HTTP_BAD_REQUEST,
            InvalidNameLengthException::class => Response::HTTP_BAD_REQUEST,
            InvalidEmailException::class => Response::HTTP_BAD_REQUEST,
            WeakPasswordException::class => Response::HTTP_BAD_REQUEST,
            InvalidDateFormatException::class => Response::HTTP_BAD_REQUEST,
            UserAlreadyExistsException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        ];

        $statusCode = $exceptionMapping[get_class($exception)] ?? Response::HTTP_INTERNAL_SERVER_ERROR;
        $title = $statusCode === Response::HTTP_UNPROCESSABLE_ENTITY ? 'Unprocessable Entity' : 'An error occurred';

        $errorResponse = [
            'title' => $title ,
            'detail' => $exception->getMessage(),
            'status' => $statusCode
        ];

        return new JsonResponse($errorResponse, $statusCode);
    }
}