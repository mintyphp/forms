<?php

namespace MintyPHP\Tests\Validators;

use MintyPHP\Form\Validator\Validators;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    public static function addressDataProvider(): array
    {
        return [
            ['test@103mail.com', true],
            ['test.test@103mail.com', true],
            ['', false],
            ['103mail.com', false],
            ['asd@test@103mail.com', false],
        ];
    }

    #[DataProvider('addressDataProvider')]
    public function testValidEmail(string $address, bool $expected): void
    {
        $validator = Validators::email('invalid email');
        $this->assertEquals($validator->validate($address) === '', $expected);
    }
}
