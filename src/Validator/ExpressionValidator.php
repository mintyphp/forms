<?php

namespace MintyPHP\Form\Validator;

interface ExpressionValidator extends Validator
{
    public function __construct(string $value);
    public function evaluate(string $value): bool;
}
