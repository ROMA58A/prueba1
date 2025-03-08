<?php
namespace Domain\User;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class UserTest extends TestCase
{
    public function testValidUserCreation(): void
    {
        $user = new User(
            new UserId('1234567890abcdef1234567890abcdef'),
            new Name('John Doe'),
            new Email('john@example.com'),
            new Password('StrongP@ss1')
        );

        $this->assertInstanceOf(User::class, $user);
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('invalid-email');
    }

    public function testPasswordTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Password('short');
    }
}
