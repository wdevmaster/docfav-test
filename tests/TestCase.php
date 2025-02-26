<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\HttpClient\HttpClient;

abstract class TestCase extends BaseTestCase
{
    private HttpClientInterface $client;
    private string $baseUrl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = HttpClient::create();
        $this->baseUrl = $_ENV['APP_URL'] ?? 'http://localhost';
    }

    protected function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->request('GET', $this->baseUrl . $uri, $options);
    }

    protected function post(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->request('POST', $this->baseUrl . $uri, $options);
    }

    protected function put(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->request('PUT', $this->baseUrl . $uri, $options);
    }

    protected function delete(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->request('DELETE', $this->baseUrl . $uri, $options);
    }
}