<?php

namespace App\Domain\ValueObject;

use DateTimeImmutable;
use App\Domain\Exception\InvalidDateFormatException;

final class CreatedAt
{
    public function __construct(
        private readonly DateTimeImmutable $value
    ){}

    public static function now(): self
    {
        return new self(new DateTimeImmutable());
    }

    public static function fromString(string $dateTime): self
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dateTime);

        if ($date === false) {
            throw new InvalidDateFormatException();
        }

        return new self($date);
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value->format('Y-m-d H:i:s');
    }
}