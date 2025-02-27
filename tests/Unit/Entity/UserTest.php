<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\CreatedAt;

class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $name = 'John Doe';
        $email = 'john.doe@example.com';
        $plainPassword = 'Valid1Password!';

        $user = User::create($name, $email, $plainPassword);

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(UserId::class, $user->getId());
        $this->assertEquals($name, $user->getName()->getValue());
        $this->assertEquals($email, $user->getEmail()->getValue());
        $this->assertTrue($user->getPassword()->verify($plainPassword));
        $this->assertInstanceOf(CreatedAt::class, $user->getCreatedAt());
    }
}