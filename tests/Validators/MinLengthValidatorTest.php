<?php

namespace MintyPHP\Tests\Validators;

use MintyPHP\Form\Validator\Validators;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MinLengthValidatorTest extends TestCase
{
    public static function minLengthDataProvider(): array
    {
        return [
            ['', 0, true],
            ['', 1, false],
            ['1', 0, true],
            ['1', 1, true],
            ['1', 2, false],
            ['12', 1, true],
            ['12', 2, true],
            ['12', 3, false],
            ['123   78', 7, true],
            ['123   78', 8, true],
            ['123   78', 9, false],
            ['12345   ', 7, true],
            ['12345   ', 8, true],
            ['12345   ', 9, false],
            ['   45678', 7, true],
            ['   45678', 8, true],
            ['   45678', 9, false],
        ];
    }

    #[DataProvider('minLengthDataProvider')]
    public function testValidExpression(string $input, int $length, bool $expected): void
    {
        $validator = Validators::minLength($length, 'invalid length');
        $this->assertEquals($validator->validate($input) === '', $expected);
    }
}
