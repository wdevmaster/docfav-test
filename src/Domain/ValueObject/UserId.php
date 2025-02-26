<?php

namespace App\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use App\Domain\Exception\InvalidUuidException;

final class UserId
{
    public function __construct(
        private readonly UuidInterface $value
    ) {}

    public static function create(): self
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $value): self
    {
        if (!Uuid::isValid($value)) {
            throw new InvalidUuidException($value);
        }
        return new self(Uuid::fromString($value));
    }

    public function getValue(): UuidInterface
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value->toString();
    }
}