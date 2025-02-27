<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

if ($request->getMethod() === 'GET' && $request->getPathInfo() === '/') {
    $response = new Response(json_encode(['message' => 'Welcome to the API']), Response::HTTP_OK, ['content-type' => 'application/json']);
    $response->send();
    return;
}

if ($request->getMethod() === 'POST' && $request->getPathInfo() === '/user/register') {
    $response = $registerUserController->__invoke($request);
    $response->send();
} else {
    $response = new Response(json_encode(['error' => 'Method not allowed']), Response::HTTP_METHOD_NOT_ALLOWED, ['content-type' => 'application/json']);
    $response->send();
}