<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Types\Types;

#[Entity]
#[Table(name: 'users')]
final class User
{
    #[Id, Column(type: Types::STRING,  unique: true)]
    private $id;

    #[Column(type: Types::STRING,  length: 255)]
    private $name;

    #[Column(type: Types::STRING,  length: 180, unique: true)]
    private $email;

    #[Column(type: Types::STRING, length: 255)]
    private $password;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private $createdAt;

    public function __construct(
        string $id, 
        string $name, 
        string $email, 
        string $password, 
        \DateTime $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}