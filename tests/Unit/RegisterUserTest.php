<?php

namespace Tests\Unit;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Event\UserRegisteredEvent;

use App\Application\RegisterUser;
use App\Application\CheckUserExists;

use App\Presentation\DTO\RegisterUserRequest;
use App\Presentation\DTO\RegisterUserResponse;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\EventDispatcher\EventDispatcherInterface;

class RegisterUserTest extends TestCase
{
    private MockObject $userRepository;
    private MockObject $eventDispatcher;
    private RegisterUser $registerUser;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $this->registerUser = new RegisterUser(
            $this->userRepository,
            new CheckUserExists($this->userRepository),
            $this->eventDispatcher
        );
    }

    public function testExecuteSuccessfullyRegistersUser(): void
    {
        $request = new RegisterUserRequest(
            'John Doe',
            'user@example.com',
            'ValidPassword!1'
        );

        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(UserRegisteredEvent::class));

        $response = $this->registerUser->execute($request);

        $this->assertInstanceOf(RegisterUserResponse::class, $response);
    }
}
