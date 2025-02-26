<?php

namespace Tests\Unit\ValueObject;

use App\Domain\ValueObject\Password;
use App\Domain\Exception\WeakPasswordException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function testCreateValidPassword()
    {
        $password = Password::create('Valid1Password!');
        $this->assertInstanceOf(Password::class, $password);
        $this->assertTrue($password->verify('Valid1Password!'));
    }

    public function testCreatePasswordTooShort()
    {
        $this->expectException(WeakPasswordException::class);
        $this->expectExceptionMessage('Password must be at least 8 characters long.');
        Password::create('Short1!');
    }

    public function testCreatePasswordNoUppercase()
    {
        $this->expectException(WeakPasswordException::class);
        $this->expectExceptionMessage('Password must include at least one uppercase letter.');
        Password::create('valid1password!');
    }

    public function testCreatePasswordNoNumber()
    {
        $this->expectException(WeakPasswordException::class);
        $this->expectExceptionMessage('Password must include at least one number.');
        Password::create('ValidPassword!');
    }

    public function testCreatePasswordNoSpecialCharacter()
    {
        $this->expectException(WeakPasswordException::class);
        $this->expectExceptionMessage('Password must include at least one special character.');
        Password::create('Valid1Password');
    }

    public function testVerifyPassword()
    {
        $password = Password::create('Valid1Password!');
        $this->assertTrue($password->verify('Valid1Password!'));
        $this->assertFalse($password->verify('InvalidPassword1!'));
    }
}