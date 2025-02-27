<?php

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\CreatedAt;

use App\Infrastructure\Persistence\Doctrine\Entity\User as DoctrineUser;

use DateTime;

final class UserMapper
{
    public static function toDoctrineEntity(User $user): DoctrineUser
    {
        return new DoctrineUser(
            $user->getId()->toString(),
            $user->getName()->getValue(),
            $user->getEmail()->getValue(),
            $user->getPassword()->getValue(),
            DateTime::createFromImmutable($user->getCreatedAt()->getValue())
        );
    }

    public static function toDomainEntity(DoctrineUser $doctrineUser): User
    {
        return new User(
            UserId::fromString($doctrineUser->getId()),
            Name::fromString($doctrineUser->getName()),
            Email::fromString($doctrineUser->getEmail()),
            new Password($doctrineUser->getPassword()),
            CreatedAt::fromString($doctrineUser->getCreatedAt())
        );
    }
}