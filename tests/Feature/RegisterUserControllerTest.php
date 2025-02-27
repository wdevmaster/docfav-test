<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

final class RegisterUserControllerTest extends TestCase
{
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $GLOBALS['userRepository'];
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->post('/user/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'ValidPassword!1'
        ], [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals('John Doe', $responseData['name']);
        $this->assertEquals('john.doe@example.com', $responseData['email']);
        $this->assertArrayHasKey('createdAt', $responseData);
        // Verify that the user was saved in the database
        $user = $this->userRepository->findByEmail('john.doe@example.com');
        $this->assertNotNull($user);
        $this->assertEquals($responseData['id'], $user->getId()->toString());
    }

    public function test_it_throws_an_exception_when_user_is_already_registered(): void
    {
        $response = $this->post('/user/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'ValidPassword!1'
        ], [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_it_throws_an_exception_when_data_is_invalid(): void
    {
        $response = $this->post('/user/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short'
        ], [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_it_throws_an_exception_when_password_is_weak(): void
    {
        $response = $this->post('/user/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'weakpassword'
        ], [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertEquals(422, $response->getStatusCode());
    }
}