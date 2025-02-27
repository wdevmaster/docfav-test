<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;

use App\Infrastructure\Persistence\Doctrine\Mapper\UserMapper;
use App\Infrastructure\Persistence\Doctrine\Entity\User as DoctrineUser;

use Doctrine\ORM\EntityManagerInterface;

final class DoctrineUserRepository implements UserRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){}

    public function save(User $user): void
    {
        $doctrineUser = UserMapper::toDoctrineEntity($user);

        $this->entityManager->persist($doctrineUser);
        $this->entityManager->flush();
    }

    public function findByEmail(string $email): ?User
    {
        $doctrineUser = $this->entityManager
                                ->getRepository(DoctrineUser::class)
                                ->findOneBy(['email' => $email]);

        return $doctrineUser ? UserMapper::toDomainEntity($doctrineUser) : null;
    }
}
