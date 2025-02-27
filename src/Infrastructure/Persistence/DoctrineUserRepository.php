<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;

class DoctrineUserRepository implements UserRepository
{
    public function __construct(){}

    public function save(User $user): void
    {
        //
    }

    public function findByEmail(string $email): ?User
    {
        return null;
    }
}
