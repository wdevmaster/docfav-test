<?php

namespace Tests\Unit\ValueObject;


use App\Domain\ValueObject\UserId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

use App\Domain\Exception\InvalidUuidException;

class UserIdTest extends TestCase
{
    public function testCreate(): void
    {
        $userId = UserId::create();
        $this->assertInstanceOf(UserId::class, $userId);
    }

    public function testFromString(): void
    {
        $uuidString = Uuid::uuid4()->toString();
        $userId = UserId::fromString($uuidString);
        $this->assertInstanceOf(UserId::class, $userId);
        $this->assertEquals($uuidString, $userId->toString());
    }

    public function testInvalidUuidString(): void
    {
        $this->expectException(InvalidUuidException::class);
        UserId::fromString('invalid-uuid-string');
    }

    public function testGetValue(): void
    {
        $uuid = Uuid::uuid4();
        $userId = new UserId($uuid);
        $this->assertSame($uuid, $userId->getValue());
    }

    public function testToString(): void
    {
        $uuid = Uuid::uuid4();
        $userId = new UserId($uuid);
        $this->assertEquals($uuid->toString(), $userId->toString());
    }
}

