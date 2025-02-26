<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidEmailException;

final class Email
{
    public function __construct(
        private readonly string $value
    ){}

    public static function fromString(string $value): self
    {
        self::ensureIsValidEmail($value);
        return new self($value);
    }

    private static function ensureIsValidEmail(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($value);
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
