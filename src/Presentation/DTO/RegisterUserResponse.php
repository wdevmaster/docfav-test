<?php

namespace App\Presentation\DTO;

use App\Domain\Entity\User;

final class RegisterUserResponse
{
    private string $id;
    private string $name;
    private string $email;
    private string $createdAt;

    public function __construct(User $user)
    {
        $this->id = $user->getId()->toString();
        $this->name = $user->getName()->getValue();
        $this->email = $user->getEmail()->getValue();
        $this->createdAt = $user->getCreatedAt()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}