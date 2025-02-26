<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\WeakPasswordException;

final class Password
{
    public function __construct(
        private readonly string $value
    ){}

    public static function create(string $plainPassword): self
    {
        self::ensureIsValid($plainPassword);
        return new self(password_hash($plainPassword, PASSWORD_DEFAULT));
    }

    private static function ensureIsValid(string $plainPassword): void
    {
        if (strlen($plainPassword) < 8) {
            throw new WeakPasswordException("Password must be at least 8 characters long.");
        }

        if (!preg_match('/[A-Z]/', $plainPassword)) {
            throw new WeakPasswordException("Password must include at least one uppercase letter.");
        }

        if (!preg_match('/\d/', $plainPassword)) {
            throw new WeakPasswordException("Password must include at least one number.");
        }

        if (!preg_match('/[^a-zA-Z\d]/', $plainPassword)) {
            throw new WeakPasswordException("Password must include at least one special character.");
        }
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}