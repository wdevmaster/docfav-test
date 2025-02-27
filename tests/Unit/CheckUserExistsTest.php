<?php

namespace Tests\Unit;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Exception\UserAlreadyExistsException;

use App\Application\CheckUserExists;

use App\Presentation\DTO\RegisterUserRequest;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CheckUserExistsTest extends TestCase
{
    private MockObject $userRepository;
    private CheckUserExists $checkUserExists;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->checkUserExists = new CheckUserExists($this->userRepository);
    }

    public function testUserExistsThrowsException(): void
    {
        $email = 'user@example.com';
        $request = new RegisterUserRequest(
            'John Doe',
            $email,
            'ValidPassword!1'
        );
        $user = User::create(
            $request->getName(),
            $request->getEmail(),
            $request->getPassword()
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn($user);

        $this->expectException(UserAlreadyExistsException::class);

        $this->checkUserExists->execute($request);
    }

    public function testUserDoesNotExist(): void
    {
        $email = 'user@example.com';
        $request = new RegisterUserRequest(
            'John Doe',
            $email,
            'ValidPassword!1'
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn(null);

        $this->checkUserExists->execute($request);

        $this->assertTrue(true); // If no exception is thrown, the test passes
    }
}