<?php

namespace Tests\Unit\ValueObject;

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Name;
use App\Domain\Exception\InvalidNameLengthException;
use App\Domain\Exception\InvalidNameCharactersException;

class NameTest extends TestCase
{
    public function testValidName()
    {
        $name = Name::fromString('John Doe');
        $this->assertInstanceOf(Name::class, $name);
        $this->assertEquals('John Doe', $name->getValue());
    }

    public function testNameTooShort()
    {
        $this->expectException(InvalidNameLengthException::class);
        Name::fromString('Jo');
    }

    public function testNameWithInvalidCharacters()
    {
        $this->expectException(InvalidNameCharactersException::class);
        Name::fromString('John123');
    }

    public function testNameWithSpecialCharacters()
    {
        $this->expectException(InvalidNameCharactersException::class);
        Name::fromString('John@Doe');
    }
}