<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\CreatedAt;

final class User
{
    public function __construct(
        private readonly UserId $id, 
        private Name $name, 
        private Email $email, 
        private Password $password,
        private readonly CreatedAt $createdAt    
    ){}

    public static function create(string $name, string $email, string $plainPassword): self 
    {
        return new self(
            UserId::create(),
            Name::fromString($name),
            Email::fromString($email),
            Password::create($plainPassword),
            CreatedAt::now()
        );
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getCreatedAt(): CreatedAt
    {
        return $this->createdAt;
    }
}