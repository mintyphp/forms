<?php

namespace MintyPHP\Tests\Validators;

use MintyPHP\Form\Validator\Validators;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ExpressionValidatorTest extends TestCase
{
    public static function expressionDataProvider(): array
    {
        return [
            ['10', '>', '9', true],
            ['10', '>=', '10', true],
            ['10', '<', '11', true],
            ['10', '<=', '10', true],
            ['10.5', '>', '9.5', true],
            ['10.5', '<=', '10.5', true],
            ['10.5', '>=', '10.5', true],
            ['10.5', '<', '10.5', false],
            ['10.5', '>', '10.5', false],
            ['10.5', '<=', '9.5', false],
            ['10.5', '>=', '11.5', false],
            ['10.5', '<', '11.5', true],
            ['10.5', '>=', '9.5', true],
            ['10.5', '<=', '9.99999', false],
            ['9.99999', '<=', '11.0', true],
        ];
    }

    #[DataProvider('expressionDataProvider')]
    public function testValidExpression(string $input, string $comperator, string $value, bool $expected): void
    {
        $validator = Validators::expression($comperator, $value, 'invalid value');
        $this->assertEquals($validator->validate($input) === '', $expected);
    }
}
