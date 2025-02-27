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

    public function testFromArray()
    {
        $data = [
            'id' => '123e4567-e89b-12d3-a456-426614174000',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => password_hash('Valid1Password!', PASSWORD_DEFAULT),
            'created_at' => '2023-10-01 12:00:00'
        ];

        $user = User::fromArray($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($data['id'], $user->getId()->toString());
        $this->assertEquals($data['name'], $user->getName()->getValue());
        $this->assertEquals($data['email'], $user->getEmail()->getValue());
        $this->assertEquals($data['password'], $user->getPassword()->getValue());
        $this->assertEquals($data['created_at'], $user->getCreatedAt()->toString());
    }
}