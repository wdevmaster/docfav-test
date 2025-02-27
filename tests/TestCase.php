<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Exception\ServerException;
use Monolog\Logger;

abstract class TestCase extends BaseTestCase
{
    private HttpClientInterface $client;
    private string $baseUrl;
    private Logger $logger;

    protected function setUp(): void
    {
        $this->logger = $GLOBALS['logger'];
        $this->client = HttpClient::create();
        $this->baseUrl = $_ENV['APP_URL'] ?? 'http://localhost';
    }

    protected function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->request('GET', $this->baseUrl . $uri, $options);
    }

    protected function post(string $uri, array $data = [], array $options = []): ResponseInterface
    {
        $options['json'] = $data;
        try {
            return  $this->client->request('POST', $this->baseUrl . $uri, $options);
        } catch (ServerException $e) {
            return $e->getResponse();
        } catch (ClientException $e) {
            return $e->getResponse();
        }
    }
}