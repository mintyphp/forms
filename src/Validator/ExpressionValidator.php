<?php

namespace MintyPHP\Form\Validator;

interface ExpressionValidator
{
    public function __construct(string $value);
    public function evaluate(string $value): bool;
}
