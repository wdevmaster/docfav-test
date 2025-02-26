<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidNameLengthException;
use App\Domain\Exception\InvalidNameCharactersException;

final class Name
{
    public function __construct(
        private readonly string $value
    ){}

    public static function fromString(string $value): self
    {
        self::ensureIsValid($value);
        return new self($value);
    }

    private static function ensureIsValid(string $value): void
    {
        if (strlen($value) < 3) {
            throw new InvalidNameLengthException();
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $value)) {
            throw new InvalidNameCharactersException();
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}