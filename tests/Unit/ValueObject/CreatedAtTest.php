<?php

namespace Tests\Domain\ValueObject;

use App\Domain\ValueObject\CreatedAt;
use App\Domain\Exception\InvalidDateFormatException;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CreatedAtTest extends TestCase
{
    public function testNow(): void
    {
        $createdAt = CreatedAt::now();
        $this->assertInstanceOf(CreatedAt::class, $createdAt);
        $this->assertInstanceOf(DateTimeImmutable::class, $createdAt->getValue());
    }

    public function testFromStringValidFormat(): void
    {
        $dateTimeString = '2023-10-05 12:34:56';
        $createdAt = CreatedAt::fromString($dateTimeString);
        $this->assertInstanceOf(CreatedAt::class, $createdAt);
        $this->assertEquals($dateTimeString, $createdAt->toString());
    }

    public function testFromStringInvalidFormat(): void
    {
        $this->expectException(InvalidDateFormatException::class);
        CreatedAt::fromString('invalid-date-format');
    }

    public function testGetValue(): void
    {
        $dateTime = new DateTimeImmutable('2023-10-05 12:34:56');
        $createdAt = new CreatedAt($dateTime);
        $this->assertSame($dateTime, $createdAt->getValue());
    }

    public function testToString(): void
    {
        $dateTimeString = '2023-10-05 12:34:56';
        $dateTime = new DateTimeImmutable($dateTimeString);
        $createdAt = new CreatedAt($dateTime);
        $this->assertEquals($dateTimeString, $createdAt->toString());
    }
}