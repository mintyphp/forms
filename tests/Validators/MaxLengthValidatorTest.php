<?php

namespace MintyPHP\Tests\Validators;

use MintyPHP\Form\Validator\Validators;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MaxLengthValidatorTest extends TestCase
{
    public static function maxLengthDataProvider(): array
    {
        return [
            ['', 0, true],
            ['', 1, true],
            ['😜', 0, false],
            ['😜', 1, true],
            ['😜', 2, true],
            ['12', 1, false],
            ['12', 2, true],
            ['12', 3, true],
            ['123   78', 7, false],
            ['123   78', 8, true],
            ['123   78', 9, true],
            ['12345   ', 4, false],
            ['12345   ', 5, true],
            ['12345   ', 6, true],
            ['12345   ', 7, true],
            ['   45678', 4, false],
            ['   45678', 5, true],
            ['   45678', 6, true],
            ['   45678', 7, true],
        ];
    }

    #[DataProvider('maxLengthDataProvider')]
    public function testValidExpression(string $input, int $length, bool $expected): void
    {
        $validator = Validators::maxLength($length, 'invalid length');
        $this->assertEquals($validator->validate($input) === '', $expected);
    }
}
