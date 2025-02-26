<?php

namespace Tests\Unit\ValueObject;

use App\Domain\ValueObject\Email;
use App\Domain\Exception\InvalidEmailException;

use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $email = Email::fromString('user@example.com');
        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals('user@example.com', $email->getValue());
    }

    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidEmailException::class);
        Email::fromString('invalid-email');
    }
}